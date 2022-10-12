<?php

namespace App\Facades;

use App\Services\BlockchainAPI\BlockchainAPIService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection|string getTickersBySymbols(string $symbolFrom, string $symbolTo)
 */
class Blockchain extends Facade
{
    protected static function getFacadeAccessor() { return BlockchainAPIService::class; }
}
