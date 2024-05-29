<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Reset cached roles and permissions
        // app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $user = User::create([
            'name' => 'KTM RUSH',
            'email' => 'ktmrushservices@gmail.com',
            'phone' => '9843XXXXXX',
            'country' => 1,
            'state' => 1,
            'district' => 1,
            'city' => 1,
            'password' => bcrypt('kathmandu@123'),
            'email_verified_at' => Carbon::now(),
        ]);
        
        $role = Role::create(['name' => 'super-admin']);
        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
