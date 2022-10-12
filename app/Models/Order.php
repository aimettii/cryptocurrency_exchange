<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    public $fillable = [
        'currency_from',
        'currency_to',
        'value',
        'converted_value',
        'rate'
    ];

    protected $casts = [
        'value' => Money::class,
        'rate' => Money::class,
        'converted_value' => Money::class,
    ];

    public function currencyFrom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_from');
    }

    public function currencyTo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_to');
    }
}
