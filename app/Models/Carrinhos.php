<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Carrinhos extends Model
{
    protected $fillable = [
        'usuarios_id',
        'ofertas_id',
    ];

    public function ofertas(): BelongsTo
    {
        return $this->belongsTo(Ofertas::class, 'ofertas_id');
    }

    public static function porUsuario(int $id_usuario): Collection
    {
        $query = self::query();

        $query->where('usuarios_id', $id_usuario);
        $query->with('ofertas');

        return $query->get();
    }

    public static function porCookie(array $cookie): Collection
    {
        $ids_ofertas = collect($cookie)->pluck('ofertas_id')->unique()->values();

        $query = Ofertas::query();
        $query->whereIn('id', $ids_ofertas);
        $ofertas = $query->get()->keyBy('id');

        return collect($cookie)->map(function ($item) use ($ofertas) {
            return (object) [
                'id' => $item['id'],
                'ofertas_id' => $item['ofertas_id'],
                'ofertas' => $ofertas->get($item['ofertas_id'])
            ];
        });
    }

    public static function itemEstaNoCarrinho(int $id_usuario, int $id_item): bool
    {
        return self::where('usuarios_id', $id_usuario)
            ->where('ofertas_id', $id_item)
            ->exists();
    }

    public static function criarItem(int $id_usuario, int $id_item)
    {
        // primeiro verificar se o item existe, pois um usuário
        // não pode ter o mesmo item mais de uma vez no carrinho

        $existe = self::where('usuarios_id', $id_usuario)
            ->where('ofertas_id', $id_item)
            ->exists();

        if ($existe) {
            return null;
        }

        return self::create([
            'usuarios_id' => $id_usuario,
            'ofertas_id' => $id_item,
        ]);
    }

    public static function excluirItemPorIdEUsuario(int $id_usuario, int $oferta_id)
    {
        $query = self::query();

        $query->where('usuarios_id', $id_usuario);
        $query->where('ofertas_id', $oferta_id);

        return $query->delete();
    }

    public static function excluirTodosPorUsuario(int $id_usuario)
    {
        $query = self::query();
        $query->where('usuarios_id', $id_usuario);

        return $query->delete();
    }
}
