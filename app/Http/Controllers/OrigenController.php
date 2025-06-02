<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\origen; // Assuming you have an Origen model
use Inertia\Inertia;

class OrigenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $origenes = origen::all();
        return Inertia::render('origenes.index', compact('origenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('origenes.create');
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
        origen::create($request->all());
        return redirect()->route('origenes.index')->with('success', 'Origen creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return Inertia::render('origenes.edit',compact('origen'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, origen $origen)
    {
        $request->validate([
        'pais' => 'required|string|max:255',
    ]);

        $origen->update($request->all());

        return redirect()->route('origenes.index')->with('success', 'Origen actualizado correctamente.');
    }

    public function destroy(origen $origen)
    {
        $origen->delete();
        return redirect()->route('origenes.index')->with('success', 'Origen eliminado correctamente.');
    }

}
