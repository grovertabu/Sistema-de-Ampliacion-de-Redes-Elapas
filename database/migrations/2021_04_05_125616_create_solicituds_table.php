<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_sol', 100);
            $table->integer('celular_sol');
            $table->string('zona_sol', 150);
            $table->string('calle_sol', 100);
            $table->date('fecha_sol');
            $table->string('estado_sol', 30);
            $table->string('x_aprox', 50);
            $table->string('y_aprox', 50);
            $table->text('observaciones')->nullable();
            $table->text('ampliaciones')->nullable();
            $table->string('sol_escaneada', 50);
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
        Schema::dropIfExists('solicituds');
    }
}
