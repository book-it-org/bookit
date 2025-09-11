<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
  /**
   * Renderiza a pagina de Admin
   */
  public function mostrar(Request $request): Response
  {
    return Inertia::render('admin/Admin');
  }
}
