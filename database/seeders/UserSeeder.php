<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Top5',
            'email' => 'contato@top5.com',
            'password' => Hash::make('12345678'),
            'role' => 'controle',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // adiciona usuário de role web
        DB::table('users')->insert([
            'name' => 'Web',
            'email' => 'webuser@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
