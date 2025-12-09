<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Documento implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $digits = preg_replace('/\D/', '', $value);

        if (strlen($digits) === 11) {
            // CPF
            if (! $this->validarCpf($digits)) {
                $fail('CPF inválido.');
            }
        } elseif (strlen($digits) === 14) {
            // CNPJ
            if (! $this->validarCnpj($digits)) {
                $fail('CNPJ inválido.');
            }
        } else {
            $fail('Documento inválido.');
        }
    }

    private function validarCpf(string $cpf): bool
    {
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$t] != $d) {
                return false;
            }
        }

        return true;
    }

    private function validarCnpj(string $cnpj): bool
    {
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $peso1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $peso2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($t = 12; $t <= 13; $t++) {
            $soma = 0;
            $peso = $t === 12 ? $peso1 : $peso2;

            for ($i = 0; $i < count($peso); $i++) {
                $soma += $cnpj[$i] * $peso[$i];
            }

            $digito = $soma % 11;
            $digito = $digito < 2 ? 0 : 11 - $digito;

            if ($cnpj[$t] != $digito) {
                return false;
            }
        }

        return true;
    }

}
