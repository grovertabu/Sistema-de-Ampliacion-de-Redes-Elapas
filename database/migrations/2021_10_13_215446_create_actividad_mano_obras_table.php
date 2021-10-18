<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadManoObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad_mano_obras', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',50);
            $table->string('unidad_medida',50);
            $table->float('precio_unitario', 8,2);
            $table->boolean('activo')->default('1');
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
        Schema::dropIfExists('actividad_mano_obras');
    }
}
