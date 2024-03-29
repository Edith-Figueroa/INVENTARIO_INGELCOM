<?php
namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Models\Firmas;
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
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),            
            'firma' => ['nullable', 'string'], 
        ])->validate();
    
        // Obtener la firma de la imagen o del canvas
        $imagen = isset($input['imagen']) ? file_get_contents($input['imagen']->getRealPath()) : null;
        $firma = new Firmas();
        
        if ($imagen) {
            // Si se ha subido un archivo de imagen
            $firma->firma = $imagen;
        } else {
            // Si la firma proviene del canvas
            $signatureData = $input['firma'];
            $signature = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData));
            $firma->firma = $signature;
        }
    
        // Guardar la firma en la base de datos
        $firma->save();
    
        // Crear un nuevo usuario con la referencia a la firma guardada
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),            
            'idRole' => 6,
            'idFirma' => $firma->id,
        ]);
    
        return $user;
    }
}