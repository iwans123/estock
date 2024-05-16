<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // make role
        $roleAdmin = ModelsRole::create([
            'name' => 'admin',
        ]);

        $roleToko1 = ModelsRole::create([
            'name' => 'toko-1',
        ]);

        $roleToko2 = ModelsRole::create([
            'name' => 'toko-2',
        ]);

        // make permission
        $permissionDahsbord = Permission::create([
            'name' => 'view_dashbord'
        ]);

        $permissionShop1 = Permission::create([
            'name' => 'view_first_shop'
        ]);

        $permissionShop2 = Permission::create([
            'name' => 'view_second_shop'
        ]);

        $permissionWarehouse = Permission::create([
            'name' => 'view_warehouse'
        ]);

        // give role a permission
        $roleAdmin->givePermissionTo($permissionDahsbord, $permissionShop1, $permissionShop2, $permissionWarehouse);
        $roleToko1->givePermissionTo($permissionShop1, $permissionShop2);
        $roleToko2->givePermissionTo($permissionShop1, $permissionShop2);

        // give user a role
        $userAdmin = User::find(1);
        $userToko1 = User::find(2);
        $userToko2 = User::find(3);

        $userAdmin->assignRole('admin');
        $userToko1->assignRole('toko-1');
        $userToko2->assignRole('toko-2');
    }
}
