<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    $rol1 = Role::create(['name' => 'Administrador']);
    $rol2 = Role::create(['name' => 'JefeInventario']);
    $rol3 = Role::create(['name' => 'RRHH']);
    $rol4 = Role::create(['name' => 'Administración']);
    $rol5 = Role::create(['name' => 'Supervisor']);
    $rol6 = Role::create(['name' => 'Usuario']);
    $user = User::find(1); //ASIGNAMOS AL PRIMER USUARIO COMO ADMINISTRADOR
    $user->assignRole($rol1);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
    }
};
