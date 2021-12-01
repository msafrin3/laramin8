<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin3',
            'display_name' => 'Admin',
            'description' => 'System Administrator'
        ]);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin3@gmail.com',
            'password' => bcrypt('admin123')
        ]);

        $user->attachRole($admin);
    }
}
