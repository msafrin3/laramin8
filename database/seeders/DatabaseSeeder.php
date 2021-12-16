<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'System Administrator'
        ]);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123')
        ]);

        $user->attachRole($admin);
    }
}
