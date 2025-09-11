<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfertasSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = DB::table('usuarios')->where('papeis_id', 2)->pluck('id');
        $idiomas = DB::table('idiomas')->pluck('id')->toArray();
        $generos = DB::table('generos')->pluck('id')->toArray();

        $livros = [
            ['titulo' => 'Dom Casmurro', 'autor' => 'Machado de Assis', 'isbn' => '9788525406262'],
            ['titulo' => 'O Cortiço', 'autor' => 'Aluísio Azevedo', 'isbn' => '9788579027048'],
            ['titulo' => 'Memórias Póstumas de Brás Cubas', 'autor' => 'Machado de Assis', 'isbn' => '9788579027055'],
            ['titulo' => 'O Guarani', 'autor' => 'José de Alencar', 'isbn' => '9788525406279'],
            ['titulo' => 'Iracema', 'autor' => 'José de Alencar', 'isbn' => '9788525406286'],
            ['titulo' => 'Senhora', 'autor' => 'José de Alencar', 'isbn' => '9788525406293'],
            ['titulo' => 'O Ateneu', 'autor' => 'Raul Pompéia', 'isbn' => '9788579027062'],
            ['titulo' => 'Casa-Grande & Senzala', 'autor' => 'Gilberto Freyre', 'isbn' => '9788525406309'],
            ['titulo' => 'Capitães da Areia', 'autor' => 'Jorge Amado', 'isbn' => '9788525406316'],
            ['titulo' => 'Gabriela, Cravo e Canela', 'autor' => 'Jorge Amado', 'isbn' => '9788525406323'],
            ['titulo' => 'O Auto da Compadecida', 'autor' => 'Ariano Suassuna', 'isbn' => '9788525406330'],
            ['titulo' => 'Vidas Secas', 'autor' => 'Graciliano Ramos', 'isbn' => '9788525406347'],
            ['titulo' => 'São Bernardo', 'autor' => 'Graciliano Ramos', 'isbn' => '9788525406354'],
            ['titulo' => 'Angústia', 'autor' => 'Graciliano Ramos', 'isbn' => '9788525406361'],
            ['titulo' => 'Macunaíma', 'autor' => 'Mário de Andrade', 'isbn' => '9788525406378'],
        ];

        $estados = ['novo', 'usado', 'desgastado'];

        foreach ($usuarios as $usuarioId) {
            for ($i = 0; $i < 3; $i++) {
                $livro = $livros[array_rand($livros)];
                $estado = $estados[array_rand($estados)];
                $idiomaAleatorio = $idiomas[array_rand($idiomas)];

                $preco = rand(1000, 15000) / 100;

                $ofertaId = DB::table('ofertas')->insertGetId([
                    'usuarios_id' => $usuarioId,
                    'idiomas_id' => $idiomaAleatorio,
                    'titulo' => $livro['titulo'] . ' - ' . ucfirst($estado),
                    'descricao' => 'Livro em estado ' . $estado . '. ' . $livro['titulo'] . ' de ' . $livro['autor'] . '. Uma excelente obra da literatura brasileira.',
                    'preco' => $preco,
                    'titulo_livro' => $livro['titulo'],
                    'autor_livro' => $livro['autor'],
                    'estado_livro' => $estado,
                    'isbn_livro' => $livro['isbn'],
                    'data_publicacao_livro' => now()->subYears(rand(5, 50))->format('Y-m-d H:i:s'),
                    'ativo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $quantidadeGeneros = rand(1, 2);
                $generosAleatorios = array_rand(array_flip($generos), $quantidadeGeneros);

                if (!is_array($generosAleatorios)) {
                    $generosAleatorios = [$generosAleatorios];
                }

                foreach ($generosAleatorios as $generoId) {
                    DB::table('ofertas_generos')->insert([
                        'ofertas_id' => $ofertaId,
                        'generos_id' => $generoId,
                    ]);
                }
            }
        }
    }
}
