<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disciplines = Discipline::orderBy('name')->paginate(10);
        return view('disciplines.index', compact('disciplines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('disciplines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Discipline::create($validated);

        return redirect()->route('disciplines.index')->with('success', 'Discipline créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discipline $discipline)
    {
        return view('disciplines.show', compact('discipline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discipline $discipline)
    {
        return view('disciplines.edit', compact('discipline'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discipline $discipline)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $discipline->update($validated);

        return redirect()->route('disciplines.index')->with('success', 'Discipline mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discipline $discipline)
    {
        $discipline->delete();

        return redirect()->route('disciplines.index')->with('success', 'Discipline supprimée avec succès.');
    }
}
