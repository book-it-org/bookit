<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegistrarUsuarioController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Registrar');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'nome_usuario' => 'required|string|max:255|unique:'.User::class,
            'data_nascimento' => 'required|date',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'senha' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefone' => 'required|string|max:15|unique:'.User::class,
            'documento' => 'required|string|max:14|unique:'.User::class
        ]);

        $user = User::create([
            'nome' => $request->nome,
            'sobrenome' => $request->sobrenome,
            'nome_usuario' => $request->nome_usuario,
            'data_nascimento' => $request->data_nascimento,
            'email' => $request->email,
            'senha_hash' => Hash::make($request->senha),
            'telefone' => $request->telefone,
            'documento' => $request->documento
        ]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('home');
    }
}
