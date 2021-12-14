<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create(
            [
                'name' => 'Admin',
                'email' => 'admin',
                'password' => bcrypt('password'),
            ]
        )->assignRole('administrador');
        User::create(
            [
                'name'     => 'Patricio Condori',
                'email'    => 'p_condori',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Inspector',
            ]
        )->assignRole('Inspector');
        User::create(
            [
                'name'     => 'Alfredo Arízaga',
                'email'    => 'a_arizada',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Inspector',
            ]
        )->assignRole('Inspector');
        User::create(
            [
                'name'     => 'Anacleto Lopez',
                'email'    => 'a_lopez',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Inspector',
            ]
        )->assignRole('Inspector');
        User::create(
            [
                'name'     => 'Desiderio Flores',
                'email'    => 'd_flores',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Inspector',
            ]
        )->assignRole('Inspector');
        User::create(
            [
                'name'     => 'Rene Iglesias',
                'email'    => 'r_iglesias',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Jefe de red',
            ]
        )->assignRole('Jefe de red');
        User::create(
            [
                'name'     => 'Nancy Nuñez',
                'email'    => 'n_nuñez',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Secretaria',
            ]
        )->assignRole('Secretaria');
        User::create(
            [
                'name'     => 'Tomás Hurtado',
                'email'    => 't_hurtado',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Monitor',
            ]
        )->assignRole('Monitor');
        User::create(
            [
                'name'     => 'Daniela Barja',
                'email'    => 'd_barja',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Proyectista',
            ]
        )->assignRole('Proyectista');
        User::factory(10)->create();
    }
}
