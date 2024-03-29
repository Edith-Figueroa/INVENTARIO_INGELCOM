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
        Schema::create('requisiciones', function (Blueprint $table) {
            $table->id();
            $table->text('Detalle');
            $table->text('Email_Entrega')->nullable();
            $table->integer('Firma_Entrega')->nullable();
            $table->text('Email_Receptor')->nullable();
            $table->integer('Firma_Receptor')->nullable();
            $table->text('Supervisor')->nullable();
            $table->text('Email_Sup')->nullable();
            $table->integer('Firma_Sup')->nullable();
            $table->text('RRHH')->nullable();
            $table->text('Email_RRHH')->nullable();
            $table->integer('Firma_RRHH')->nullable();
            $table->text('Administracion')->nullable();            
            $table->text('Email_Adminis')->nullable();
            $table->integer('Firma_Adminis')->nullable();
            $table->boolean('Estado')->nullable();
            $table->date('Fecha')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisiciones');
    }
};
