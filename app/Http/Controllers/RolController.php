<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return Inertia::render('roles/Index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        return Inertia::render('roles/Create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:255']);
        Rol::create($request->only('nombre'));
        return redirect()->route('admin.roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit(Rol $rol)
    {
        return Inertia::render('roles/Edit', [
            'rol' => $rol
        ]);
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate(['nombre' => 'required|string|max:255']);
        $rol->update($request->only('nombre'));
        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
