<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ofertas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
  /**
   * Renderiza a pagina de Admin
   */
  public function mostrar(Request $request): Response
  {
    $ofertasBloqueadas = Ofertas::where('bloqueado', true)
      ->with(['usuario', 'genero', 'idioma'])
      ->orderBy('updated_at', 'desc')
      ->get();

    $placeholderUrl = null;
    if (Storage::disk('public')->exists('ofertas/placeholder.jpg')) {
      $placeholderUrl = Storage::url('ofertas/placeholder.jpg');
    }

    return Inertia::render('admin/Admin', [
      'ofertasBloqueadas' => $ofertasBloqueadas,
      'placeholderUrl' => $placeholderUrl,
    ]);
  }

  /**
   * Faz upload do placeholder de oferta
   */
  public function uploadPlaceholder(Request $request)
  {
    $request->validate([
      'placeholder' => 'required|image|mimes:jpeg,jpg|max:2048',
    ]);

    $file = $request->file('placeholder');

    // Remove o placeholder antigo se existir
    if (Storage::disk('public')->exists('ofertas/placeholder.jpg')) {
      Storage::disk('public')->delete('ofertas/placeholder.jpg');
    }

    // Salva o novo placeholder com o nome fixo
    $file->storeAs('ofertas', 'placeholder.jpg', 'public');

    return back()->with('success', 'Placeholder atualizado com sucesso!');
  }

  /**
   * Desbloqueia uma oferta
   */
  public function desbloquearOferta(Request $request, $id)
  {
    $oferta = Ofertas::findOrFail($id);
    $oferta->bloqueado = false;
    $oferta->save();

    return back()->with('success', 'Oferta desbloqueada com sucesso!');
  }
}
