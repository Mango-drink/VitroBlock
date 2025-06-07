<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:usuario,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()->min(8),// <--- fuerza mínimo de 8 caracteres
            ],
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = Usuario::create([
            'nombre' => $request->name, 
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'rol_id' => 2, // Siempre cliente
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirección según rol (puedes expandir en el futuro si registras admins)
        if ($user->rol_id == 1) {
            return redirect('/admin/dashboard');
        }
        return redirect('/productos')->with('success', '¡Bienvenido a la plataforma! Tu registro fue exitoso.');

    }
}
