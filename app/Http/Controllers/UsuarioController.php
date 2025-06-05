<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
            return Inertia::render('usuarios/Index', ['usuarios' => $usuarios]);
         $user = auth()->user();
        // ... otros datos que quieras pasar
            return Inertia::render('usuarios/Index', [
            'user' => $user,
        // ...más props si quieres
        ]);
    }

    public function create()
    {
        $roles = Rol::all();
        return Inertia::render('usuarios/Create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuario,email',
            'password_hash' => 'required|string|min:6',
            'rol_id' => 'required|exists:rol,rol_id',
        ]);
        Usuario::create($request->only('nombre', 'email', 'password_hash', 'rol_id'));
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(Usuario $usuario)
    {
        $roles = Rol::all();
        return Inertia::render('usuarios/Edit', [
            'usuario' => $usuario,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuario,email,' . $usuario->usuario_id . ',usuario_id',
            'rol_id' => 'required|exists:rol,rol_id',
        ]);
        $usuario->update($request->only('nombre', 'email', 'rol_id'));
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
