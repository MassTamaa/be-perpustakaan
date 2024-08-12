<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesAdmin = Roles::where('name', 'owner')->first();

        User::create(
            [
                'name' => 'owner',
                'email' => 'owner@gmail.com',
                'role_id' => $rolesAdmin->id,
                'password' => Hash::make('perpustakaan'),
            ]
        );
    }
}
