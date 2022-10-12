<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public $table = 'currencies';

    public $fillable = [
        'symbol'
    ];

    protected $casts = [
        'symbol' => 'string'
    ];

    public static $rules = [
        'symbol' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function ordersConvertedByFrom(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Order::class, 'currency_from');
    }

    public function ordersConvertedByTo(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Order::class, 'currency_to');
    }

    public function tickersFrom(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Ticker::class, 'currency_from');
    }

    public function tickersTo(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Ticker::class, 'currency_to');
    }
}
