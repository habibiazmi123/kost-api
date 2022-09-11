<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['name' => 'Owner', 'guard_name' => 'web'],
            ['name' => 'Regular', 'guard_name' => 'web'],
            ['name' => 'Premium', 'guard_name' => 'web'],
        ]);

        Permission::insert([
            ['name' => 'property_list', 'guard_name' => 'web'],
            ['name' => 'property_create', 'guard_name' => 'web'],
            ['name' => 'property_update', 'guard_name' => 'web'],
            ['name' => 'property_delete', 'guard_name' => 'web'],
            ['name' => 'ask_availability', 'guard_name' => 'web'],
        ]);

        $roleOwner = Role::where("name", "Owner")->first();

        $roleOwner->givePermissionTo(Permission::whereIn("name", [
            "property_list",
            "property_create",
            "property_update",
            "property_delete"
        ])
        ->get());

        $roleRegular = Role::where("name", "Regular")->first();

        $roleRegular->givePermissionTo(Permission::whereIn("name", [
            "ask_availability"
        ])
        ->get());

        $rolePremium = Role::where("name", "Premium")->first();

        $rolePremium->givePermissionTo(Permission::whereIn("name", [
            "ask_availability",
        ])
        ->get());
    }
}
