<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $universities = University::orderBy('name')->paginate(10);
        return view('universities.index', compact('universities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('universities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'nullable|string|max:50',
        ]);

        University::create($validated);

        return redirect()->route('universities.index')->with('success', 'Université créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(University $university)
    {
        return view('universities.show', compact('university'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(University $university)
    {
        return view('universities.edit', compact('university'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, University $university)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'nullable|string|max:50',
        ]);

        $university->update($validated);

        return redirect()->route('universities.index')->with('success', 'Université mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(University $university)
    {
        $university->delete();

        return redirect()->route('universities.index')->with('success', 'Université supprimée avec succès.');
    }
}
