<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Money implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (!preg_match("/^\-?[0-9]*\.?[0-9]+\z/", $value)) {
            return rtrim(number_format($value, 10), '0');
        }
        return $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
