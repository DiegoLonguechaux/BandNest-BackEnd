<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les rôles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $musician = Role::create(['name' => 'musician']);
        $owner = Role::create(['name' => 'owner']);

        // Créer les permissions
        $createStructures = Permission::create(['name' => 'create structures']);
        $editStructures = Permission::create(['name' => 'edit structures']);
        $deleteStructures = Permission::create(['name' => 'delete structures']);
        
        $createRooms = Permission::create(['name' => 'create rooms']);
        $editRooms = Permission::create(['name' => 'edit rooms']);
        $deleteRooms = Permission::create(['name' => 'delete rooms']);

        $createBands = Permission::create(['name' => 'create bands']);
        $editBands = Permission::create(['name' => 'edit bands']);
        $deleteBands = Permission::create(['name' => 'delete bands']);

        // Assigner des permissions aux rôles
        $superAdmin->givePermissionTo([
            $createStructures, 
            $editStructures, 
            $deleteStructures, 
            $createRooms, 
            $editRooms, 
            $deleteRooms
        ]);
        $owner->givePermissionTo([
            $createStructures, 
            $editStructures, 
            $deleteStructures, 
            $createRooms, 
            $editRooms, 
            $deleteRooms
        ]);
        $musician->givePermissionTo([
            $createBands, 
            $editBands, 
            $deleteBands
        ]);
    }
}
