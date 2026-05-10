<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import User model
use App\Models\Role; // Import Role model
use Illuminate\Support\Facades\Hash; // For password hashing

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $SuperAdminRole = Role::where('name', 'Super Admin')->first();
        $AdminRole = Role::where('name', 'Admin')->first();
        $PMRole = Role::where('name', 'Project Manager')->first();

        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            ['name' => 'Super Admin User', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'role_id' => $SuperAdminRole->id]
        );

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'role_id' => $AdminRole->id]
        );

        User::firstOrCreate(
            ['email' => 'PM@example.com'],
            ['name' => 'PM User', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'role_id' => $PMRole->id]
        );
    }
}
