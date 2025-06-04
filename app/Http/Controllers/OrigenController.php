<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Origen; // Assuming you have an Origen model
use Inertia\Inertia;

class OrigenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $origenes = Origen::all();
        return Inertia::render('origenes/Index', compact('origenes'));
        //return view('origenes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('origenes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'pais' => 'required|string|max:255'
        ]);
        Origen::create($validated);
        return redirect()->route('origenes.index')->with('success', 'Origen creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $origen = Origen::findOrFail($id);
        return Inertia::render('origenes/Show', compact('origen'));
        //return view('origenes.show', compact('origen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Origen $origen)
    {
        return Inertia::render('origenes/Edit', compact('origen'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Origen $origen)
    {
        $validated = $request->validate([
        'pais' => 'required|string|max:255',
    ]);

        $origen->update($validated);

        return redirect()->route('origenes.index')->with('success', 'Origen actualizado correctamente.');
    }

    public function destroy(Origen $origen)
    {
        $origen->delete();
        return redirect()->route('origenes.index')->with('success', 'Origen eliminado correctamente.');
    }

}
