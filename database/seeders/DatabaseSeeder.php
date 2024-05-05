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
                'username' => 'admin2',
                'password' => Hash::make('12345678'),
                'privilege' => 'admin',
                'full_name' => 'admin admin',
                'created_at' => '2024-02-24 19:23:58',
                'updated_at' => '2024-02-24 19:23:58'
            ],
            [
                'username' => 'superuser2',
                'password' => Hash::make('12345678'),
                'privilege' => 'superuser',
                'full_name' => 'superuser superuser',
                'created_at' => '2024-02-24 19:23:58',
                'updated_at' => '2024-02-24 19:23:58'
            ],
            [
                'username' => 'user2',
                'password' => Hash::make('12345678'),
                'privilege' => 'user',
                'full_name' => 'user user',
                'created_at' => '2024-02-24 19:23:58',
                'updated_at' => '2024-02-24 19:23:58'
            ],
            // Add more users as needed
        ];

        // Insert the users into the database
        DB::table('users')->insert($users);

        
    }
}
