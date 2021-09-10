<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcavacionVecinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excavacion_vecinos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('informe_id');
            $table->unsignedBigInteger('actividad_descargo_id');
            $table->string('u_medida',20)->nullable();
            $table->float('cantidad',8,2)->nullable();
            $table->float('precio_unitario',8,2)->nullable();
            $table->foreign('informe_id')
                    ->references('id')
                    ->on('informes')
                    ->onDelete('cascade');
            $table->foreign('actividad_descargo_id')
                    ->references('id')
                    ->on('actividad_descargos')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('excavacion_vecinos');
    }
}
