<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateAporteMVecinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aporte_m_vecinos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('informe_id');
            $table->string('u_medida',20)->nullable();
            $table->integer('cantidad')->nullable();
            $table->float('precio_unitario',8,2)->nullable();
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
        Schema::dropIfExists('aporte_m_vecinos');
    }
}
