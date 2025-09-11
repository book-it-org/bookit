<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsuariosSeeder::class,
            OfertasSeeder::class,
        ]);
    }
}
