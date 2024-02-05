<?php
namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     * 
     */
    
 public function create(array $input)
    {
    Validator::make($input, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => $this->passwordRules(),
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        'firma_source' => ['nullable', 'string'], // Validar la fuente de la firma
        'firma' => ['nullable', 'string'], // Agregar validación para la firma si es necesario
    ])->validate();

    $user = User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'firma' => null, // Inicializamos a null
        'firma_source' => null, // Inicializamos a null
    ]);
    
    // Verificar si se proporcionó una firma en el canvas
    if (isset($input['firma_canvas'])) {
        $user->update([
            'firma' => $input['firma_canvas'],
            'firma_source' => 'canvas',
        ]);
    } elseif (isset($input['firma_file'])) {
        // Verificar si se proporcionó un archivo de firma
        $firmaFile = $input['firma_file'];
        $firmaPath = $firmaFile->store('firma', 'public'); // Almacenar la firma en storage/public/firma
        $user->update([
            'firma' => $firmaPath,
            'firma_source' => 'imagen',
        ]);
    }
    
    // Asignar el rol por defecto 'Usuario' al nuevo usuario
    $defaultRole = Role::where('name', 'Usuario')->first();

    if ($defaultRole) {
        $user->assignRole($defaultRole);
    }

    return $user;
}

}