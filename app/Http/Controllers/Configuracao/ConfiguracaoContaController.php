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
        if ($usuario) {
            $stats = Avaliacoes::where('vendedor_id', $usuario->id)
                ->selectRaw('COUNT(*) as total, COALESCE(AVG(nota),0) as media')
                ->first();

            $total = $stats->total ?? 0;
            $media = $stats->media ?? 0;
        }

        return Inertia::render('configuracao/ConfiguracaoConta', [
            'media_avaliacoes' => (float) $media,
            'total_avaliacoes' => (int) $total,
        ]);
    }
}
