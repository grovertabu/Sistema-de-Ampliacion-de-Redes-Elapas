<?php

namespace Database\Seeders;

use App\Models\Actividad_mano_obra;
use Illuminate\Database\Seeder;

class Actividad_mano_obraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Actividad_mano_obra::create(
            [
                "descripcion" => "Tendido de Tuberia",
                "unidad_medida" => "M3",
                "precio_unitario" => "1.00"
            ]
            );
        Actividad_mano_obra::create(
            [
                "descripcion" => "Excavacion",
                "unidad_medida" => "M3",
                "precio_unitario" => "72.22"
            ]
            );
        Actividad_mano_obra::create(
            [
                "descripcion" => "Cama de Tierra",
                "unidad_medida" => "M3",
                "precio_unitario" => "17.28"
            ]
            );
        Actividad_mano_obra::create(
            [
                "descripcion" => "Relleno Material Seleccionado",
                "unidad_medida" => "M3",
                "precio_unitario" => "23.04"
            ]
            );
        Actividad_mano_obra::create(
            [
                "descripcion" => "Relleno Material Comun",
                "unidad_medida" => "M3",
                "precio_unitario" => "23.04"
            ]
            );

    }
}
