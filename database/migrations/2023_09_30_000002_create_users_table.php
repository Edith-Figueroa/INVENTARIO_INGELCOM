<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {    
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('Estado', ['Activo', 'Inactivo'])->default('Activo');            
            $table->rememberToken();
            $table->integer('idFirma')->nullable();                 
            $table->foreignId('idRole')->nullable()->constrained('roles');
        });

        // Crear un usuario por defecto
        $defaultUser = [
            'name' => 'INGELCOM ADMIN',
            'email' => 'ingelcomtec@gmail.com',
            'password' => Hash::make('ING3LCOM123%'),
            'Estado' => 'Activo',            
            'idFirma' => 0,
        ];

        // Insertar el usuario por defecto
        User::create($defaultUser);

        // Asignar el rol de Administrador al usuario por defecto
        $adminRole = Role::where('name', 'Administrador')->first();
        $defaultUserInstance = User::where('email', 'ingelcomtec@gmail.com')->first();

        if ($adminRole && $defaultUserInstance) {
            $defaultUserInstance->assignRole($adminRole);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
