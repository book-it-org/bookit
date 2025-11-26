<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use App\Models\Carrinhos;
use App\Models\Generos;
use App\Models\Ofertas;
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

        return Inertia::render('oferta/Oferta', [
            'oferta' => $oferta,
            'generos' => $generos,
            'estaNoCarrinho' => $estaNoCarrinho,
            'permissoes' => [
                'podeGerenciar' => $podeGerenciar,
                'admin' => $admin,
                'dono' => $dono,
                'podeAtivar' => $dono && ! $oferta->bloqueado,
            ],
        ]);
    }
}
