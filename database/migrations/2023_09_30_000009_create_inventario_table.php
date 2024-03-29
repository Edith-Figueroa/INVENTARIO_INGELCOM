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
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('IdProducto');

            $table->text('Notas')->nullable();
            $table->integer('Cantidad');
            $table->timestamps();

            $table->foreign('IdProducto')->references('IdProducto')->on('productos');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     
        Schema::dropIfExists('inventario');
    }


};
