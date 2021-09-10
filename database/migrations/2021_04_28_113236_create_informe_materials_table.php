<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformeMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('informe_id');
            $table->unsignedBigInteger('material_id');
            $table->integer('cantidad');
            $table->string('u_medida',20);
            $table->foreign('informe_id')
                    ->references('id')
                    ->on('informes')
                    ->onDelete('cascade');
            $table->foreign('material_id')
                    ->references('id')
                    ->on('materials')
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
        Schema::dropIfExists('informe_materials');
    }
}
