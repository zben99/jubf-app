<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\University;
use App\Models\Discipline;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;





class EtudiantController extends Controller
{

public function index(Request $request)
{
    $search        = $request->input('search');
    $universityId  = $request->input('university_id');
    $disciplineId  = $request->input('discipline_id');
    $statut        = $request->input('statut');

    $etudiants = Etudiant::with(['university', 'discipline'])
        ->when($search, fn($q) => $q->where(function ($q) use ($search) {
            $q->where('nom',       'like', "%{$search}%")
              ->orWhere('prenom',  'like', "%{$search}%")
              ->orWhere('ine',     'like', "%{$search}%")
              ->orWhere('matricule','like',"%{$search}%")
              ->orWhere('telephone','like',"%{$search}%");
        }))
        ->when($universityId, fn($q) => $q->where('university_id', $universityId))
        ->when($disciplineId, fn($q) => $q->where('discipline_id', $disciplineId))
        ->when($statut,       fn($q) => $q->where('statut', $statut))
        ->orderBy('nom')
        ->paginate(20)
        ->withQueryString();

    $universities = University::orderBy('name')->get();
    $disciplines  = Discipline::orderBy('name')->get();

    return view('etudiants.index', compact(
        'etudiants', 'search', 'universityId', 'disciplineId', 'statut',
        'universities', 'disciplines'
    ));
}

    public function create()
    {
        if (! Setting::registrationOpen()) {
            return view('etudiants.closed');
        }

        $universities = University::orderBy('name')->get();
        $disciplines  = Discipline::orderBy('name')->get();

        return view('etudiants.create', compact('universities', 'disciplines'));
    }

    public function store(Request $request)
    {
        if (! Setting::registrationOpen()) {
            abort(403, 'Les inscriptions sont actuellement fermées.');
        }

        // 1) Validation des champs (photo_path obligatoire, etc.)
        $isEncadreurOuOrganisateur = in_array($request->input('statut'), ['Encadreur', 'Organisateur']);

        $validated = $request->validate([
            'nom'            => 'required|string|max:255',
            'prenom'         => 'required|string|max:255',
            'sexe'           => 'required|string|in:Masculin,Féminin',
            'ine'            => [
                'nullable', 'string', 'max:255',
                Rule::unique('etudiants', 'ine')->whereNull('deleted_at'),
                Rule::when(! $isEncadreurOuOrganisateur, ['required_without:matricule']),
            ],
            'matricule'      => [
                'nullable', 'string', 'max:255',
                Rule::unique('etudiants', 'matricule')->whereNull('deleted_at'),
                Rule::when(! $isEncadreurOuOrganisateur, ['required_without:ine']),
            ],
            'date_naissance' => 'required_unless:statut,Encadreur,Organisateur|date',
            'telephone'      => 'nullable|string|max:20',
            'university_id'  => 'required|exists:universities,id',
            'statut'         => 'required|string|in:Sportif,Artiste,Encadreur,Organisateur',
            'discipline_id'  => 'required|exists:disciplines,id',
            'photo_path'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2) Chercher un enregistrement existant (actif ou supprimé) sur (nom, prenom, date_naissance, telephone)
        $existing = Etudiant::withTrashed()
            ->where('nom', $validated['nom'])
            ->where('prenom', $validated['prenom'])
            ->where('date_naissance', $validated['date_naissance'])
            ->where('telephone', $validated['telephone'])
            ->first();

        if ($existing && ! $existing->trashed()) {
            return back()
                ->withInput()
                ->withErrors([
                    'doublon' => 'Un(e) étudiant(e) portant le même nom, prénom et date de naissance existe déjà.'
                ]);
        }

        // 3) Stockage du fichier uploadé dans 'public/photos_etudiants'
        if ($request->hasFile('photo_path')) {
            $file = $request->file('photo_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/photos_etudiants'), $filename);
            $validated['photo_path'] = 'photos_etudiants/' . $filename;
        }

        // 4) Si le candidat avait été supprimé → le restaurer avec les nouvelles données
        if ($existing && $existing->trashed()) {
            $existing->restore();
            $existing->update($validated);

            return redirect()
                ->route('etudiants.create')
                ->with('success', "Réinscription réussie ! Votre code d'inscription : <strong>{$existing->code}</strong>.");
        }

        // 5) Génération d'un code numérique de 4 caractères unique
        do {
            $codeUnique = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Etudiant::where('code', $codeUnique)->exists());

        $validated['code'] = $codeUnique;

        // 6) Création du nouvel étudiant
        Etudiant::create($validated);

        // 7) Redirection avec message de succès (affiche le code)
        return redirect()
            ->route('etudiants.create')
            ->with('success', "Inscription réussie ! Votre code d'inscription : <strong>{$codeUnique}</strong>.");
    }


    public function show(Etudiant $etudiant)
    {
        return view('etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        return view('etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'ine' => 'nullable|string|unique:etudiants,ine,' . $etudiant->id . '|required_without:matricule',
            'matricule' => 'nullable|string|unique:etudiants,matricule,' . $etudiant->id . '|required_without:ine',
            'date_naissance' => 'required|date',
            'telephone' => 'nullable|string',
            'university_id' => 'required|exists:universities,id',
            'statut' => 'nullable|string',
            'discipline_id' => 'required|exists:disciplines,id',
        ]);

        $etudiant->update($request->all());

        return redirect()->route('etudiants.index')->with('success', 'Mise à jour réussie.');
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return redirect()->back()->with('success', 'Candidat supprimé avec succès.');
    }

    public function destroyBulk(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:etudiants,id',
        ]);

        $count = Etudiant::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', $count . ' candidat' . ($count > 1 ? 's supprimés' : ' supprimé') . ' avec succès.');
    }








        public function generate($id)
{
  $etudiant = Etudiant::findOrFail($id);

    $manager = new ImageManager();
    $badge = $manager->read(public_path('images/badges/badge_template.png'));

    // Ajout de la photo
    $badge->place(public_path('storage/photos/' . $etudiant->photo), 100, 150);

    // Texte nom
    $badge->text($etudiant->nom, 350, 160, function ($font) {
        $font->filename(public_path('fonts/Roboto-Bold.ttf'));
        $font->size(36);
        $font->color('000000');
    });

    // Enregistrement
    $path = public_path('badges/badge_' . $etudiant->code . '.png');
    $badge->save($path);

    return response()->download($path);
}



public function showBadge1($id)
{
       $etudiant = Etudiant::findOrFail($id);

 $pdf = Pdf::loadView('etudiants.template', compact('etudiant'))
            ->setOption(['dpi' => 300, 'defaultFont' => 'sans-serif'])
          ->setPaper([0, 0, 297.6, 419.5], 'portrait'); // 105mm × 148mm
         // ->setOption('defaultFont', 'sans-serif');

    return $pdf->download('badge_' . $etudiant->code . '.pdf');
}


public function downloadBadgesBatch()
{
    $etudiants = Etudiant::all(); // ou un filtre : Etudiant::where(...)->get();

    $pdfRecto = Pdf::loadView('etudiants.badges_recto', compact('etudiants'))
        ->setPaper('a4', 'portrait')
        ->setOption(['dpi' => 300, 'defaultFont' => 'sans-serif']);

    $pdfVerso = Pdf::loadView('etudiants.badges_verso', compact('etudiants'))
        ->setPaper('a4', 'portrait')
        ->setOption(['dpi' => 300, 'defaultFont' => 'sans-serif']);

    // Fusionner les deux PDF pour faire du recto-verso
    // En Laravel/DomPDF pur, ce n'est pas possible directement
    // Alternative : stocker chaque PDF, les fusionner avec `setOptions(['enable-javascript' => true])` ou via package externe (ex: `mikehaertl/pdftk` ou `fpdi`)

    // Temporaire : retourner les deux PDF séparément
    return response()->streamDownload(function () use ($pdfRecto, $pdfVerso) {
        //echo $pdfRecto->output();
        echo $pdfVerso->output();
    }, 'badges_recto_verso.pdf');
}



public function telechargerBadgesold()
{
    ini_set('memory_limit', '512M');
set_time_limit(180);
    $etudiants = Etudiant::where('universite', 'Université Saint Thomas d\'Aquin')
    ->get();

    $html = view('etudiants.badges_recto_verso', compact('etudiants'))->render();

    $pdf = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

    return $pdf->download('badges_recto_verso.pdf');
}


public function telechargerBadges1()
{


    $html = view('etudiants.badges_recto_versoco')->render();

    $pdf = Pdf::loadHTML($html)->setPaper('A4', 'portrait');
    return $pdf->download('badges_recto_versoco.pdf');
}




public function telechargerBadges222()
{
    ini_set('max_execution_time', 3600);

    // Récupérer tous les étudiants groupés par université
    $grouped = Etudiant::all()
        ->groupBy('universite');

    $pdfs = []; // Pour stocker les chemins des fichiers PDF

    foreach ($grouped as $universite => $etudiants) {
        $slug = Str::slug($universite);
        $folderPath = storage_path("app/public/badges/$slug/");

        // Créer le dossier s'il n'existe pas
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        foreach ($etudiants as $etudiant) {
            $fileName = "badge_" . $etudiant->code . ".pdf";
            $filePath = $folderPath . $fileName;

            // Ne rien faire si le fichier existe déjà
            if (!file_exists($filePath)) {
                $pdf = Pdf::loadView('etudiants.template', compact('etudiant'))
                    ->setOption(['dpi' => 300, 'defaultFont' => 'sans-serif'])
                    ->setPaper([0, 0, 283.5, 391.0], 'portrait'); // 100mm x 138mm

                file_put_contents($filePath, $pdf->output());
            }

            $pdfs[] = $filePath;
        }
    }

    // Retourner les liens vers les fichiers PDF générés
    return response()->json([
        'message' => 'Tous les badges ont été générés.',
        'files' => array_map(function ($path) {
            return asset(str_replace(storage_path('app/public'), 'storage', $path));
        }, $pdfs)
    ]);
}



public function badgesExport()
{
    $universities = University::withCount(['etudiants as etudiants_count' => fn($q) => $q->where('statut', '!=', 'Organisateur')])
        ->having('etudiants_count', '>', 0)
        ->orderBy('name')
        ->get();

    $disciplines = Discipline::withCount('etudiants')
        ->having('etudiants_count', '>', 0)
        ->orderBy('name')
        ->get();

    $totalCandidats    = Etudiant::count();
    $totalOrganisateurs = Etudiant::where('statut', 'Organisateur')->count();

    return view('etudiants.badges_export', compact('universities', 'disciplines', 'totalCandidats', 'totalOrganisateurs'));
}

public function telechargerBadgesOrganisateurs()
{
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    $etudiants = Etudiant::with(['university', 'discipline'])
        ->where('statut', 'Organisateur')
        ->orderBy('nom')
        ->get()
        ->chunk(4);

    $html = view('etudiants.badges_recto', compact('etudiants'))->render();
    $pdf  = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

    return $pdf->download('badges_organisateurs.pdf');
}

public function telechargerBadges()
{
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    $etudiants = Etudiant::with(['university', 'discipline'])->get()->chunk(4);

    $html = view('etudiants.badges_recto', compact('etudiants'))->render();
    $pdf  = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

    return $pdf->download('badges_tous.pdf');
}

public function telechargerBadgesByUniversity(int $universityId)
{
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    $university = University::findOrFail($universityId);
    $etudiants  = Etudiant::with(['university', 'discipline'])
        ->where('university_id', $universityId)
        ->where('statut', '!=', 'Organisateur')
        ->orderBy('nom')
        ->get()
        ->chunk(4);

    $html = view('etudiants.badges_recto', compact('etudiants'))->render();
    $pdf  = Pdf::loadHTML($html)->setPaper('A4', 'portrait');
    $slug = \Illuminate\Support\Str::slug($university->acronym ?: $university->name);

    return $pdf->download("badges_{$slug}.pdf");
}

public function telechargerBadgesByDiscipline(int $disciplineId)
{
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    $discipline = Discipline::findOrFail($disciplineId);
    $etudiants  = Etudiant::with(['university', 'discipline'])
        ->where('discipline_id', $disciplineId)
        ->orderBy('nom')
        ->get()
        ->chunk(4);

    $html = view('etudiants.badges_recto', compact('etudiants'))->render();
    $pdf  = Pdf::loadHTML($html)->setPaper('A4', 'portrait');
    $slug = \Illuminate\Support\Str::slug($discipline->name);

    return $pdf->download("badges_{$slug}.pdf");
}

public function showBadge(int $id)
{
    $etudiant  = Etudiant::with(['university', 'discipline'])->findOrFail($id);
    $etudiants = collect([$etudiant])->chunk(4);

    $html = view('etudiants.badges_recto', compact('etudiants'))->render();
    $pdf  = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

    return $pdf->stream('badge_' . $etudiant->code . '.pdf');
}

}
