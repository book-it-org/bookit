<?php

namespace Database\Seeders\Essentials;

use Illuminate\Database\Seeder;

class EssentialsSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            GenerosSeeder::class,
            IdiomasSeeder::class,
            EstadosSeeder::class,
            PapeisSeeder::class,
        ]);
    }
}
