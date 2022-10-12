<?php

namespace App\Facades;

use App\Services\CoingeckoAPI\CoingeckoAPIService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection|string getTickersBySymbols(string $symbolFrom, string $symbolTo)
 */
class Coingecko extends Facade
{
    protected static function getFacadeAccessor() { return CoingeckoAPIService::class; }
}
