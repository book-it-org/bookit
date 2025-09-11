<?php

namespace Database\Seeders\Essentials;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenerosSeeder extends Seeder
{
    public function run(): void
    {
        $generos = [
            'ROMANCE',
            'BIOGRAFIA',
            'FICCAO CIENTIFICA',
            'INFANTIL',
            'AVENTURA',
            'FANTASIA',
            'AUTOAJUDA',
            'LITERATURA TECNICA',
            'RELIGIAO',
            'TERROR',
            'OUTROS',
        ];

        foreach ($generos as $genero) {
            DB::table('generos')->insert([
                'nome' => $genero,
            ]);
        }
    }
}
