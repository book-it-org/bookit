<?php

namespace App\Http\Controllers\Ofertas;

use App\Http\Controllers\Controller;
use App\Models\Ofertas;
use App\Rules\Isbn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CriarOfertaController extends Controller
{
    public function criarOferta(Request $request): RedirectResponse
    {
        $request->validate([
            'generos_id' => 'required|exists:generos,id',
            'idiomas_id' => 'required|exists:idiomas,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'preco' => 'required|numeric|min:0',
            'titulo_livro' => 'required|string|max:255',
            'autor_livro' => 'required|string|max:255',
            'estado_livro' => 'required',
            'isbn_livro' => ['required','regex:/^\d{11}$|^\d{13}$/'],
            'editora' => 'nullable|string|max:255',
            'data_publicacao_livro' => 'required|date',
            'imagens' => 'nullable|array',
            'imagens.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = array_merge($request->all(), ['usuarios_id' => Auth::id()]);

        // store first uploaded image as capa_url (public disk)
        if ($request->hasFile('imagens')) {
            $files = $request->file('imagens');
            if (is_array($files) && count($files) > 0) {
                $file = $files[0];
                $path = $file->store('ofertas', 'public');
                $data['capa_url'] = Storage::url($path);
            } elseif ($files) {
                $path = $files->store('ofertas', 'public');
                $data['capa_url'] = Storage::url($path);
            }
        }

        $oferta = Ofertas::criarOferta($data, $request->generos_id);

        return Redirect::route('anuncios');
    }

    public function editarOferta(Request $request, $id): RedirectResponse
    {
        $oferta = Ofertas::buscarOfertaPorIdEUsuario($id, Auth::id());


        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'preco' => 'required|numeric|min:0',
            'editora' => 'nullable|string|max:255',
            'imagens' => 'nullable|array',
            'imagens.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $capaUrl = null;
        if ($request->hasFile('imagens')) {
            $files = $request->file('imagens');
            if (is_array($files) && count($files) > 0) {
                $file = $files[0];
                $path = $file->store('ofertas', 'public');
                $capaUrl = Storage::url($path);
            } elseif ($files) {
                $path = $files->store('ofertas', 'public');
                $capaUrl = Storage::url($path);
            }
        }

        $oferta->editar($request->titulo, $request->descricao, $request->preco, $request->editora ?? null, $capaUrl);

        return Redirect::route('anuncios');
    }
}
