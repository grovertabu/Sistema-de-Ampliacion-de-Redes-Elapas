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
                'name'     => 'Grover Taboada',
                'email'    => 'grovert',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Inspector',
            ]
        )->assignRole('Inspector');
        User::create(
            [
                'name'     => 'Carlos Vasquez',
                'email'    => 'carlos',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Inspector',
            ]
        )->assignRole('Inspector');
        User::create(
            [
                'name'     => 'Rene Iglesias',
                'email'    => 'Catastro',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Jefe de red',
            ]
        )->assignRole('Jefe de red');
        User::create(
            [
                'name'     => 'Sofia Mendez',
                'email'    => 'sofia',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Secretaria',
            ]
        )->assignRole('Secretaria');
        User::create(
            [
                'name'     => 'Pedro Perez',
                'email'    => 'pedro',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Monitor',
            ]
        )->assignRole('Monitor');
        User::create(
            [
                'name'     => 'Patricia Patiño',
                'email'    => 'patricia',
                'password' =>  bcrypt('password'),
                'tipo_user' => 'Proyectista',
            ]
        )->assignRole('Proyectista');
        User::factory(10)->create();
    }
}
