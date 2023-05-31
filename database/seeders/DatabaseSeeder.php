<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('admin123!')
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('admin123!')
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin3@gmail.com',
            'password' => Hash::make('admin123!')
        ]);
    }
}
