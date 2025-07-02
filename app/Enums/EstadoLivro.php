<?php

namespace App\Enums;

enum EstadoLivro: string
{

    case  NOVO = 'NOVO';
    case USADO = 'USADO';
    case DESGASTADO = 'DESGASTADO';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function matches(string $value): bool
    {
        return in_array($value, self::values(), true);
    }
}
