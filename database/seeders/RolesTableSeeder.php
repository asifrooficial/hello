<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'id' => '1',
            'role_name' => 'User'
        ]);

        DB::table('roles')->insert([
            'id' => '2',
            'role_name' => 'Officer'
        ]);

        DB::table('roles')->insert([
            'id' => '3',
            'role_name' => 'GM'
        ]);
    }
}
