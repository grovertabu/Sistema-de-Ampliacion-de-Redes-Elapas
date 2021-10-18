<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEjecucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ejecucions', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_progrmada');
            $table->date('fecha_ejecutada')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('informe_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('informe_id')
            ->references('id')
            ->on('informes')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('ejecucions');
    }
}
