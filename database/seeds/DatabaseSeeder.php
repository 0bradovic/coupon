<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage categories']);
        Permission::create(['name' => 'manage tags']);
        Permission::create(['name' => 'manage offers']);
        Permission::create(['name' => 'manage offer types']);
        Permission::create(['name' => 'manage roles']);
        Permission::create(['name' => 'manage slider']);
        Permission::create(['name' => 'manage seo']);
        $role = Role::create(['name' => 'Administrator']);
        $role->givePermissionTo(Permission::all());
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123')
        ]);
        $user->assignRole('Administrator');
    }
}
