<?php

namespace Database\Seeders\Essentials;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdiomasSeeder extends Seeder
{
    public function run(): void
    {
        $idiomas = [
            'PORTUGUES',
            'INGLES',
            'ESPANHOL',
            'FRANCES',
            'ALEMAO',
            'ITALIANO',
            'JAPONES',
            'CHINES',
            'COREANO',
            'RUSSO',
            'OUTROS',
        ];

        foreach ($idiomas as $idioma) {
            DB::table('idiomas')->insert([
                'nome' => $idioma,
            ]);
        }
    }
}
