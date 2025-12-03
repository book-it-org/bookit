<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use App\Models\Carrinhos;
use App\Models\Generos;
use App\Models\Ofertas;
use App\Models\Pedidos;
use App\Models\Avaliacoes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class OfertaController extends Controller
{
    /**
     * Renderiza a pagina de anunciar um livro
     */
    public function mostrar(int $id, ?string $titulo_oferta = null): Response|RedirectResponse
    {
        $oferta = Ofertas::where('id', $id)->with(['generos', 'idioma', 'usuario'])->first();

        if (! $oferta) {
            abort(404, 'Oferta não encontrada.');
        }

        $titulo_slug = $oferta->tituloParaSlug();
        if ($titulo_oferta !== $titulo_slug) {
            return Redirect::route('oferta', [
                'id' => $id,
                'titulo_oferta' => $titulo_slug,
            ]);
        }

        $generos = Generos::all();

        $usuario = auth()->user();

        // checar se a oferta está em algum pedido ativo (não cancelado)
        $existePedidoAtivo = Pedidos::where('oferta_id', $id)
            ->where('estado', '!=', 'cancelado')
            ->exists();

        // marcar disponibilidade para o front-end (se estiver em pedido não cancelado, estará indisponível para compra/carrinho)
        $pedidoIndisponivel = $existePedidoAtivo;

        $podeGerenciar = false;
        $admin = false;
        $dono = false;
        $estaNoCarrinho = false;

        if ($usuario) {
            $admin = $usuario->verificarAdmin();
            $dono = $oferta->usuarios_id === $usuario->id;
            $podeGerenciar = $admin || $dono;

            $estaNoCarrinho = Carrinhos::itemEstaNoCarrinho(
                $usuario->id,
                $oferta->id
            );
        } else {
            $cookie = request()->cookie('carrinho', '[]');
            $carrinho = json_decode($cookie, true);

            foreach ($carrinho as $item) {
                if ($item['ofertas_id'] == $oferta->id) {
                    $estaNoCarrinho = true;
                    break;
                }
            }
        }

        // attach vendedor rating
        $nota = Avaliacoes::where('vendedor_id', $oferta->usuarios_id)->avg('nota');
        $oferta->vendedor_nota = $nota ? round($nota, 1) : null;

        return Inertia::render('oferta/Oferta', [
            'oferta' => $oferta,
            'generos' => $generos,
            'estaNoCarrinho' => $estaNoCarrinho,
            'pedido_indisponivel' => $pedidoIndisponivel,
            'permissoes' => [
                'podeGerenciar' => $podeGerenciar,
                'admin' => $admin,
                'dono' => $dono,
                'podeAtivar' => $dono && ! $oferta->bloqueado,
            ],
        ]);
    }
}
