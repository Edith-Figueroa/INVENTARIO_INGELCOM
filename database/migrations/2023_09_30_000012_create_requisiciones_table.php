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
            $table->text('Entrega')->nullable();
            $table->text('Receptor')->nullable();
            $table->text('Supervisor')->nullable();
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
