<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EntrarRequest;
use App\Models\Carrinhos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use function PHPUnit\Framework\isArray;

class EntrarUsuarioController extends Controller
{
    /**
     * Show the login page.
     */
    public function mostrar(Request $request): Response
    {
        return Inertia::render('auth/Entrar', [
            'canResetPassword' => Route::has('senha.recuperar'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function entrarUsuario(EntrarRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $cookie = json_decode(($request->cookie('carrinho') ?? '[]'), true);
        if (is_array($cookie) && count($cookie) > 0) {
            $id_usuario = $request->user()->id;

            foreach ($cookie as $item) {
                Carrinhos::criarItem($id_usuario,$item['ofertas_id']);
            }

        }

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function sairUsuario(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
