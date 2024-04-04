<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'password' => Hash::make('12345678'),
                'privilege' => 'admin',
            ],
            [
                'username' => 'superuser',
                'password' => Hash::make('12345678'),
                'privilege' => 'superuser',
            ],
            [
                'username' => 'user',
                'password' => Hash::make('12345678'),
                'privilege' => 'user',
            ],
            // Add more users as needed
        ];

        // Insert the users into the database
        DB::table('users')->insert($users);

        
    }
}
