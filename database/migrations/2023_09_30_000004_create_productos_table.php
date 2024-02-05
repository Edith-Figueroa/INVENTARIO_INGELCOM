<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('IdProducto');
            $table->unsignedBigInteger('IdCategoria');
            $table->string('NombreP')->unique();
            $table->string('DescripcionP')->nullable();
            $table->enum('Estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->double('PrecioUnitario')->nullable();
            $table->double('CostoUnitario')->nullable();
            $table->double('CostoInventario')->nullable();
            $table->double('PrecioInventario')->nullable();
            $table->timestamps();

            $table->foreign('IdCategoria')->references('IdCategoria')->on('categorias'); // Establece la relación con la tabla Categorias
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
