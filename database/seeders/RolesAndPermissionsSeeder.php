<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->resetPermissions();
        $this->createRoles();
    }

    protected function resetPermissions()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    protected function createRoles()
    {
        $user = User::find(1);
        $adminRole = Role::create(['name' => 'admin']);
        $user->assignRole('admin');
    }


}
