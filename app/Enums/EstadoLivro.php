<?php

namespace App\Enums;

enum EstadoLivro: string
{

    case  NOVO = 'novo';
    case USADO = 'usado';
    case DESGASTADO = 'desgastado';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function matches(string $value): bool
    {
        return in_array($value, self::values(), true);
    }
}
