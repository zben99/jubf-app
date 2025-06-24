<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Etudiant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;





class EtudiantController extends Controller
{

public function index(Request $request)
{
    $search = $request->input('search');

    $etudiants = Etudiant::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('universite', 'like', "%{$search}%")
                  ->orWhere('statut', 'like', "%{$search}%")
                  ->orWhere('discipline', 'like', "%{$search}%");
            });
        })
        ->orderBy('nom')
        ->paginate(10);

    return view('etudiants.index', compact('etudiants', 'search'));
}

    public function create()
    {
        return view('etudiants.create');
    }

    public function store(Request $request)
    {
        // 1) Validation des champs (photo_path obligatoire, etc.)
        $validated = $request->validate([
            'nom'            => 'required|string|max:255',
            'prenom'         => 'required|string|max:255',
            'date_naissance' => 'required_unless:statut,Encadreur|date',
            'telephone'      => 'nullable|string|max:20',
            'universite'     => 'required|string|max:255',
            'statut'         => 'required|string|in:Sportif,Artiste,Encadreur',
            'discipline'     => 'required|string|max:255',
            'photo_path'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        // 2) Vérification de doublon sur (nom, prenom, date_naissance)
        $exists = Etudiant::where('nom', $validated['nom'])
            ->where('prenom', $validated['prenom'])
            ->where('date_naissance', $validated['date_naissance'])
            ->where('telephone', $validated['telephone'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'doublon' => 'Un(e) étudiant(e) portant le même nom, prénom et date de naissance existe déjà.'
                ]);
        }

        // 3) Stockage du fichier uploadé dans 'public/photos_etudiants'
       if ($request->hasFile('photo_path')) {
            $file = $request->file('photo_path');
            // Génère un nom unique (timestamp + nom original)
            $filename = time() . '_' . $file->getClientOriginalName();
            // Déplace le fichier directement dans public/storage/photos_etudiants
            $file->move(public_path('storage/photos_etudiants'), $filename);
            // Stocke le chemin relatif pour la BD (sans 'storage/')
            $validated['photo_path'] = 'photos_etudiants/' . $filename;
        }

        // 4) Génération d'un code numérique de 4 caractères
        //    On s'assure qu'il n'existe pas déjà en base
        do {
            $codeUnique = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Etudiant::where('code', $codeUnique)->exists());

        $validated['code'] = $codeUnique;

        // 5) Création de l'étudiant
        Etudiant::create($validated);

        // 6) Redirection avec message de succès (affiche le code)
        return redirect()
            ->route('etudiants.create')
            ->with('success', "Inscription réussie ! Votre code d’inscription : <strong>{$codeUnique}</strong>.");
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
            'date_naissance' => 'required|date',
            'telephone' => 'nullable|string',
            'universite' => 'nullable|string',
            'statut' => 'nullable|string',
            'discipline' => 'required|string',
        ]);

        $etudiant->update($request->all());

        return redirect()->route('etudiants.index')->with('success', 'Mise à jour réussie.');
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return redirect()->route('etudiants.index')->with('success', 'Suppression réussie.');
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
          ->setPaper([0, 0, 283.5, 391.0], 'portrait');
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
    // En Laravel/DomPDF pur, ce n’est pas possible directement
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
    $etudiants = Etudiant::where('universite', 'Université Saint Thomas d’Aquin')
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

        // Créer le dossier s’il n’existe pas
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



 public function telechargerBadges($limite = null)
{
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    $lastId = 1210;
    $lotSize = 100;

    /*for ($start = 1; $start <= $lastId; $start += $lotSize) {
        $end = min($start + $lotSize - 1, $lastId);
*/
        $etudiants = Etudiant::where('id', [$start, $end])->get();

      /*  if ($etudiants->isEmpty()) {
            continue; // ignorer si aucun étudiant dans l'intervalle
        }*/

        $html = view('etudiants.attestation', compact('etudiants'))->render();
        $pdf = Pdf::loadHTML($html)->setPaper('A4', 'landscape');

        // Enregistrer dans un dossier local (ex : storage/app/public/attestations/)
        $fileName = "attestations_{$start}_{$end}.pdf";

        Storage::disk('public')->put("attestations/{$fileName}", $pdf->output());

    //}

    return response()->json(['message' => 'Génération par lot terminée']);

}

public function showBadge($id)
{
       $etudiant = Etudiant::findOrFail($id);

      $etudiants = Etudiant::where('id', [$start, $end])->get();

      /*  if ($etudiants->isEmpty()) {
            continue; // ignorer si aucun étudiant dans l'intervalle
        }*/

        $html = view('etudiants.attestation', compact('etudiants'))->render();
        $pdf = Pdf::loadHTML($html)->setPaper('A4', 'landscape');

        // Enregistrer dans un dossier local (ex : storage/app/public/attestations/)
        $fileName = "attestations_{$start}_{$end}.pdf";

        Storage::disk('public')->put("attestations/{$fileName}", $pdf->output());

    //}

    return response()->json(['message' => 'Génération par lot terminée']);
}

}
