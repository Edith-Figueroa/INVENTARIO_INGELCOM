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
         Schema::create('salidas', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('IdRegistro'); 
             $table->unsignedBigInteger('IdProducto');
             $table->text('Notas')->nullable();
             $table->integer('Cantidad');
             $table->timestamps();
        
             $table->foreign('IdRegistro')->references('id')->on('requisiciones'); // Establece la relación con la tabla Requisiciones
             $table->foreign('IdProducto')->references('IdProducto')->on('productos');
     });
     }
     

    public function down()
    {
        Schema::dropIfExists('salidas');
    }
};