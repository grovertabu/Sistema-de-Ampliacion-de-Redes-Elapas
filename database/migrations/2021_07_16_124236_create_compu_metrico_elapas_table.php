<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompuMetricoElapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compu_metrico_elapas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actividad_descargo_id');
            $table->unsignedBigInteger('informe_id');
            $table->integer('nro')->nullable();
            $table->float('ancho',8,2)->nullable();
            $table->float('alto',8,2)->nullable();
            $table->float('largo',8,2)->nullable();
            $table->float('volumen',8,2)->nullable();
            $table->foreign('actividad_descargo_id')
                    ->references('id')
                    ->on('actividad_descargos')
                    ->onDelete('cascade');
            $table->foreign('informe_id')
                    ->references('id')
                    ->on('informes')
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
        Schema::dropIfExists('compu_metrico_elapas');
    }
}
