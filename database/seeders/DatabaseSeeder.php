<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\GenerosSeeder;
use Database\Seeders\IdiomasSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GenerosSeeder::class,
            IdiomasSeeder::class,
            EstadosSeeder::class,
        ]);
    }
}
