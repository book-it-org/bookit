<?php

namespace Database\Seeders;

use Database\Seeders\Development\DevelopmentSeeder;
use Database\Seeders\Essentials\EssentialsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Executando seeders essenciais...');
        $this->call([
            EssentialsSeeder::class,
            AdminSeeder::class
        ]);

        if (app()->environment('local', 'development')) {
            $this->command->info('Ambiente de desenvolvimento detectado. Executando seeders de desenvolvimento...');
            $this->call([
                DevelopmentSeeder::class,
            ]);
        } else {
            $this->command->info('Ambiente de produção detectado. Seeders de desenvolvimento pulados.');
        }

        $this->command->info('Seeding do banco de dados completo.');
    }
}
