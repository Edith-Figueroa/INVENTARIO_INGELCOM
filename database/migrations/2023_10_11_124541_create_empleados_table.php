<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned(); // Definir 'id' como un entero grande sin signo
            $table->text('Nombre');
            $table->text('Cargo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleados');
    }
};
