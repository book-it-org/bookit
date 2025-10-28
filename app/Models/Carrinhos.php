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
        $ofertas = Ofertas::whereIn('id', $ids_ofertas)->get()->keyBy('id');

        return collect($cookie)->map(function ($item) use ($ofertas) {
            return (object) [
                'id' => $item['id'],
                'ofertas_id' => $item['ofertas_id'],
                'ofertas' => $ofertas->get($item['ofertas_id'])
            ];
        });
    }

    public static function criarItem(int $id_usuario, int $item_id)
    {
        return self::create([
            'usuarios_id' => $id_usuario,
            'ofertas_id' => $item_id,
        ]);
    }

    public static function excluirItemPorIdEUsuario(int $id_usuario, int $item_id)
    {
        $query = self::query();

        $query->where('usuarios_id', $id_usuario);
        $query->where('id', $item_id);

        return $query->delete();
    }

    public static function excluirTodosPorUsuario(int $id_usuario)
    {
        $query = self::query();
        $query->where('usuarios_id', $id_usuario);

        return $query->delete();
    }
}
