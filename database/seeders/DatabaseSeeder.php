<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //        $user = User::factory()->create([
        //            'name'     => 'Test User',
        //            'email'    => 'admin@test.ru',
        //            'password' => Hash::make('12345678'),
        //        ]);

        $user = User::find(2);
        $role = Role::find(1);
        //        $permission = Permission::create(['name' => 'edit users']);
        //        $user->assignRole('admin');

        $user->assignRole($role);
    }

}
