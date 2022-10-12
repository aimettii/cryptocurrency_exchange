<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    const API_BLOCKCHAIN_TYPE = 'api_blockchain';
    const API_COINGECKO_TYPE = 'api_coingecko';
    const DEFAULT_TAX_PERCENT = 0.02; // 2 percent tax

    public $table = 'tickers';

    public $fillable = [
        'currency_from',
        'currency_to',
        'rate',
        'tax',
        'is_active',
    ];

    protected $casts = [

    ];

    public static $rules = [
        'currency_from' => 'required',
        'currency_to' => 'required',
        'rate' => 'required',
        'is_active' => 'required|boolean',
    ];

    public function getFormattedRateAttribute() : float
    {
        $formattedRate = $this->rate - ( $this->rate * $this->tax );

        if ($this->rate > 1) {
            $formattedRate = number_format($formattedRate, 2, '.', '');
        }

        return $formattedRate;
    }

    /**
     * Сгруппировать активные тикеры по валютным парам и вывести с самым большим rate
     *
     * @param $query
     * @return mixed
     */
    public function scopeActualCurrencyPairs($query)
    {
        return $query->active()->joinSub(
            self::selectRaw('currency_from,currency_to, max(rate) as max_rate')->groupByRaw('currency_from, currency_to')
            , 't2', function ($join) {
            $join->on('tickers.currency_from', '=', 't2.currency_from')
                ->on('tickers.currency_to', '=', 't2.currency_to')
                ->on('tickers.rate', '=', 't2.max_rate');
        });
    }

    public function scopeCurrenciesPair($query, Currency $currencyFrom, Currency $currencyTo)
    {
        return $query
            ->where('tickers.currency_from', $currencyFrom->id)
            ->where('tickers.currency_to', $currencyTo->id);
    }

    public function scopeActive($query, $value = true)
    {
        return $query->where('tickers.is_active', $value);
    }

    public function currencyFrom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_from');
    }

    public function currencyTo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_to');
    }
}
