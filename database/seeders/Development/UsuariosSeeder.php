<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'nome' => 'Mario',
                'sobrenome' => 'Sergio',
                'nome_usuario' => 'mario.sergio',
                'data_nascimento' => '1985-03-15 00:00:00',
                'email' => 'mario.sergio@email.com',
                'senha_hash' => Hash::make('123456'),
                'telefone' => '11999999999',
                'documento' => '12345678901',
                'papeis_id' => 2,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'João',
                'sobrenome' => 'Silva',
                'nome_usuario' => 'joao.silva',
                'data_nascimento' => '1985-03-15 00:00:00',
                'email' => 'joao.silva@email.com',
                'senha_hash' => Hash::make('123456'),
                'telefone' => '11888888888',
                'documento' => '12345678902',
                'papeis_id' => 2,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Maria',
                'sobrenome' => 'Santos',
                'nome_usuario' => 'maria.santos',
                'data_nascimento' => '1992-07-22 00:00:00',
                'email' => 'maria.santos@email.com',
                'senha_hash' => Hash::make('123456'),
                'telefone' => '11777777777',
                'documento' => '12345678903',
                'papeis_id' => 2,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Pedro',
                'sobrenome' => 'Costa',
                'nome_usuario' => 'pedro.costa',
                'data_nascimento' => '1988-11-08 00:00:00',
                'email' => 'pedro.costa@email.com',
                'senha_hash' => Hash::make('123456'),
                'telefone' => '11666666666',
                'documento' => '12345678904',
                'papeis_id' => 2,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Ana',
                'sobrenome' => 'Oliveira',
                'nome_usuario' => 'ana.oliveira',
                'data_nascimento' => '1995-05-30 00:00:00',
                'email' => 'ana.oliveira@email.com',
                'senha_hash' => Hash::make('123456'),
                'telefone' => '11555555555',
                'documento' => '12345678905',
                'papeis_id' => 2,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($usuarios as $usuario) {
            DB::table('usuarios')->insert($usuario);
        }
    }
}
