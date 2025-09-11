<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = [
            'nome' => 'Admin',
            'sobrenome' => 'Sistema',
            'nome_usuario' => 'admin',
            'data_nascimento' => '1990-01-01 00:00:00',
            'email' => 'admin@bookit.com',
            'senha_hash' => Hash::make('123456'),
            'telefone' => '99999999999',
            'documento' => '99999999999',
            'papeis_id' => 0,
            'ativo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('usuarios')->insert($usuario);
    }
}
