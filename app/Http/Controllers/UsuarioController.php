<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Traits\RegistraOperacion; // <--- Importa el Trait

class UsuarioController extends Controller
{
    use RegistraOperacion; // <--- Usa el Trait

    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        $user = auth()->user();
        return Inertia::render('usuarios/Index', [
            'usuarios' => $usuarios,
            'user' => $user,
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
            'password' => 'required|string|min:6',
            'rol_id' => 'required|exists:rol,rol_id',
        ]);
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
        ]);

        // Bitácora: registro de creación
        $this->registraOperacion(
            'alta',
            'usuarios',
            $usuario->usuario_id,
            'Creación de usuario: ' . $usuario->nombre
        );

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
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

        // Bitácora: registro de modificación
        $this->registraOperacion(
            'modificacion',
            'usuarios',
            $usuario->usuario_id,
            'Modificación de usuario: ' . $usuario->nombre
        );

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $nombre = $usuario->nombre;
        $id = $usuario->usuario_id;

        $usuario->delete();

        // Bitácora: registro de baja
        $this->registraOperacion(
            'baja',
            'usuarios',
            $id,
            'Eliminación de usuario: ' . $nombre
        );

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
