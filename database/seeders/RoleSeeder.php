<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrador']); // 1
        $role2 = Role::create(['name' => 'Jefe de red']); // 2
        $role3 = Role::create(['name' => 'Inspector']); //3
        $role4 = Role::create(['name' => 'Secretaria']); //4
        $role5 = Role::create(['name' => 'Monitor']); //5
        $role6 = Role::create(['name' => 'Proyectista']); //6


        Permission::create(['name' => 'dash'])->syncRoles([$role, $role2, $role3, $role4, $role5, $role6]);

        Permission::create(['name' => 'users.index'])->syncRoles([$role]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role]);

        Permission::create(['name' => 'solicitud.index'])->syncRoles([$role, $role2 , $role4]);
        Permission::create(['name' => 'solicitud.create'])->syncRoles([$role, $role4]);
        Permission::create(['name' => 'solicitud.edit'])->syncRoles([$role, $role4]);
        Permission::create(['name' => 'solicitud.delete'])->syncRoles([$role,$role4]);
        Permission::create(['name' => 'solicitud.ampliaciones'])->syncRoles([$role, $role2, $role3, $role4]);


        Permission::create(['name' => 'informes.index'])->syncRoles([$role,$role2, $role3]);
        Permission::create(['name' => 'informes.create'])->syncRoles([$role,$role2, $role3]);
        Permission::create(['name' => 'informes.edit'])->syncRoles([$role, $role3]);
        Permission::create(['name' => 'informes.delete'])->syncRoles([$role,$role3]);
        Permission::create(['name' => 'jefe-red'])->syncRoles([$role2]);
        Permission::create(['name' => 'inspector'])->syncRoles([$role3]);

        Permission::create(['name' => 'materials.index'])->syncRoles([$role,$role2, $role3]);
        Permission::create(['name' => 'materials.create'])->syncRoles([$role,$role2, $role3]);
        Permission::create(['name' => 'materials.edit'])->syncRoles([$role, $role3]);
        Permission::create(['name' => 'materials.delete'])->syncRoles([$role,$role3]);

        Permission::create(['name' => 'Monitor'])->syncRoles([$role5]);
        Permission::create(['name' => 'Proyectista'])->syncRoles([$role6]);

    }
}
