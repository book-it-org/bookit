<?php

namespace Database\Seeders\Essentials;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['Acre', 'AC'],
            ['Alagoas', 'AL'],
            ['Amapá', 'AP'],
            ['Amazonas', 'AM'],
            ['Bahia', 'BA'],
            ['Ceará', 'CE'],
            ['Distrito Federal', 'DF'],
            ['Espírito Santo', 'ES'],
            ['Goiás', 'GO'],
            ['Maranhão', 'MA'],
            ['Mato Grosso', 'MT'],
            ['Mato Grosso do Sul', 'MS'],
            ['Minas Gerais', 'MG'],
            ['Pará', 'PA'],
            ['Paraíba', 'PB'],
            ['Paraná', 'PR'],
            ['Pernambuco', 'PE'],
            ['Piauí', 'PI'],
            ['Rio de Janeiro', 'RJ'],
            ['Rio Grande do Norte', 'RN'],
            ['Rio Grande do Sul', 'RS'],
            ['Rondônia', 'RO'],
            ['Roraima', 'RR'],
            ['Santa Catarina', 'SC'],
            ['São Paulo', 'SP'],
            ['Sergipe', 'SE'],
            ['Tocantins', 'TO'],
        ];

        foreach ($estados as $estado) {
            DB::table('estados')->insert([
                'nome' => $estado[0],
                'sigla' => $estado[1],
            ]);
        }
    }
}
