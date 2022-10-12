<?php

namespace App\Console\Commands\Traits;

use App\Facades\Blockchain;
use App\Facades\Coingecko;
use App\Models\Ticker;
use Illuminate\Support\Collection;

trait ExchangeAPICollection
{
    public function findTickersCollections(string $symbolFrom, string $symbolTo) : Collection
    {
        $tickersExchangesResults = collect();
        $exchangeAPICallbacks = [
            Ticker::API_BLOCKCHAIN_TYPE => function() use($symbolFrom, $symbolTo) {
                return Blockchain::getTickersBySymbols($symbolFrom, $symbolTo);
            },
            Ticker::API_COINGECKO_TYPE => function() use($symbolFrom, $symbolTo) {
                return Coingecko::getTickersBySymbols($symbolFrom, $symbolTo);
            },
        ];

        foreach ($exchangeAPICallbacks as $key => $callback) {
            $this->line(sprintf("Finding in %s API...", self::getApiNames($key)));
            $result = $callback();

            if ($result instanceof Collection && !$result->isEmpty()) {
                $tickersExchangesResults->push([
                    'exchange_name' => $key,
                    'rate' => $result->first()[strtolower($symbolTo)],
                ]);
            }
        }

        return $tickersExchangesResults;
    }

    public static function getApiNames($type)
    {
        $apiNames = [
            Ticker::API_COINGECKO_TYPE => 'Coingecko',
            Ticker::API_BLOCKCHAIN_TYPE => 'Blockchain',
        ];

        return $apiNames[$type] ?? null;
    }
}
