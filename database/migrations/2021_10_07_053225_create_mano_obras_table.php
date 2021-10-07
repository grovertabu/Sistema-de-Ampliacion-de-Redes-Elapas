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
            $table->string('descripcion',40);
            $table->string('unidad',20);
            $table->integer('cantidad');
            $table->float('precio_uni',8,2);
            $table->unsignedBigInteger('ejecucion_id');
            $table->string('observador',10);
            $table->foreign('ejecucion_id')
            ->references('id')
            ->on('ejecucions')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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
        Schema::dropIfExists('mano_obras');
    }
}
