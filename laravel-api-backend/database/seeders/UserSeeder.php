<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    \App\Models\User::factory(10000)->create();

    // Optional: Add 1 admin manually
    User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);
    }
}
