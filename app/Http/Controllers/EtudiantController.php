<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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
            'date_naissance' => 'required|date',
            'telephone'      => 'nullable|string|max:20',
            'universite'     => 'nullable|string|max:255',
            'statut'         => 'required|string|in:Sportif,Artiste',
            'discipline'     => 'required|string|max:255',
            'photo_path'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2) Vérification de doublon sur (nom, prenom, date_naissance)
        $exists = Etudiant::where('nom', $validated['nom'])
            ->where('prenom', $validated['prenom'])
            ->where('date_naissance', $validated['date_naissance'])
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
            $path = $request->file('photo_path')->store('photos_etudiants', 'public');
            $validated['photo_path'] = $path;
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
}
