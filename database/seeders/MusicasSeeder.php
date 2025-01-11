<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Musica;

class MusicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Musica::factory()->count(5)->create();
    }
}
