<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManoObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mano_obras', function (Blueprint $table) {
            $table->id();
            $table->float('ancho',8,2)->nullable();
            $table->float('alto',8,2)->nullable();
            $table->float('largo',8,2);
            $table->float('cantidad',8,2);
            $table->float('precio_uni',8,2);
            $table->string('observador',10);
            $table->unsignedBigInteger('ejecucion_id');
            $table->unsignedBigInteger('actividad_id');
            $table->timestamps();
            $table->foreign('ejecucion_id')
            ->references('id')
            ->on('ejecucions')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('actividad_id')
            ->references('id')
            ->on('actividad_mano_obras')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mano_obras');
    }
}
