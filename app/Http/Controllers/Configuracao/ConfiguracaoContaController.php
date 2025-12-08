<?php

namespace App\Http\Controllers\Configuracao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Avaliacoes;

class ConfiguracaoContaController extends Controller
{
    /**
     * Renderiza a pagina de configuracao de conta
     */
    public function mostrar(Request $request): Response
    {
        $usuario = $request->user();

        $media = 0;
        $total = 0;
        $avaliacoes = [];

        if ($usuario) {
            $stats = Avaliacoes::where('vendedor_id', $usuario->id)
                ->selectRaw('COUNT(*) as total, COALESCE(AVG(nota),0) as media')
                ->first();

            $total = $stats->total ?? 0;
            $media = $stats->media ?? 0;

            // Buscar avaliações detalhadas com informações do comprador
            $avaliacoes = Avaliacoes::where('vendedor_id', $usuario->id)
                ->with('comprador:id,nome,sobrenome,nome_usuario')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get()
                ->map(function ($avaliacao) {
                    return [
                        'id' => $avaliacao->id,
                        'nota' => $avaliacao->nota,
                        'comentario' => $avaliacao->comentario,
                        'data' => $avaliacao->created_at->format('d/m/Y'),
                        'comprador' => [
                            'nome' => $avaliacao->comprador->nome ?? '',
                            'sobrenome' => $avaliacao->comprador->sobrenome ?? '',
                            'nome_usuario' => $avaliacao->comprador->nome_usuario ?? '',
                        ]
                    ];
                });
        }

        return Inertia::render('configuracao/ConfiguracaoConta', [
            'usuario' => $usuario ? [
                'nome' => $usuario->nome,
                'sobrenome' => $usuario->sobrenome,
                'nome_usuario' => $usuario->nome_usuario,
                'email' => $usuario->email,
                'telefone' => $usuario->telefone,
                'data_nascimento' => $usuario->data_nascimento,
            ] : null,
            'media_avaliacoes' => (float) $media,
            'total_avaliacoes' => (int) $total,
            'avaliacoes' => $avaliacoes,
        ]);
    }
}
