<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PapeisSeeder extends Seeder
{
    public function run(): void
    {
        $papeis = [
            ['id' => 0, 'nome' => 'ADMIN', 'descricao' => 'Administrador do sistema. Acesso total.'],
            ['id' => 1, 'nome' => 'MOD', 'descricao' => 'Moderador do sistema. Pode gerenciar conteúdos e usuários.'],
            ['id' => 2, 'nome' => 'USUARIO', 'descricao' => 'Usuário comum do sistema.'],
        ];

        foreach ($papeis as $papel) {
            DB::table('papeis')->insert($papel);
        }
    }
}
