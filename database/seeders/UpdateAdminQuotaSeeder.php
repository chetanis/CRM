<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UpdateAdminQuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'master',
                'password' => Hash::make('12345678'),
                'privilege' => 'master',
                'full_name' => 'master master',
                'created_at' => '2024-02-24 19:23:58',
                'updated_at' => '2024-02-24 19:23:58',
            ],
        ];

        // Insert the users into the database
        DB::table('users')->insert($users);
        Db::table('users')->where('privilege','admin')->update(['quota' => 20]);
    }
}
