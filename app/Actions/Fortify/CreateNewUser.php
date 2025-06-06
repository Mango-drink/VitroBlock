<?php

namespace App\Actions\Fortify;

use App\Models\Usuario; // Tu modelo personalizado
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): Usuario
    {
        dd($input);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'], // Cambia 'nombre' por 'name'
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuario,email'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Correos que serán admin (rol_id = 1)
        $adminEmails = [
            'admin@demo.com',
            'leonardo200196@gmail.com',
            // Agrega aquí otros correos de admin
        ];

        $rolId = in_array($input['email'], $adminEmails) ? 1 : 2;
        
        return Usuario::create([
            'nombre' => $input['name'], // Usa 'name' del input para el campo 'nombre' en la base
            'email' => $input['email'],
            'password_hash' => Hash::make($input['password']),
            'rol_id' => $rolId,
        ]);
    }
}
