<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha_hora_in')->nullable();
            $table->date('fecha_autorizacion')->nullable();
            $table->date('fecha_visto_bueno')->nullable();
            $table->string('espesifiar_in', 100)->nullable();
            $table->string('x_exact')->nullable();
            $table->string('y_exact')->nullable();
            $table->string('ubicacion_geo')->nullable();
            $table->string('longitud_in', 50)->nullable();
            $table->string('diametro_in', 30)->nullable();
            $table->integer('num_ben_in')->nullable();
            $table->integer('num_flia_in')->nullable();
            $table->string('condicion_rasante')->nullable();
            $table->string('reservorio', 50)->nullable();
            $table->string('tendido_u', 100)->nullable();
            $table->integer('tendido_c')->nullable();
            $table->string('excabacion', 100)->nullable();
            $table->string('tapado_sanja', 100)->nullable();
            $table->string('estado_in', 40)->nullable();
            $table->unsignedBigInteger('solicitud_id');
            $table->string('imagen_amp', 20)->nullable();
            $table->foreign('solicitud_id')
                ->references('id')
                ->on('solicituds')
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
        Schema::dropIfExists('informes');
    }
}
