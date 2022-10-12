<?php

namespace App\Services\BlockchainAPI;

use App\Services\Base\BaseAPIService;
use Illuminate\Support\Collection;

class BlockchainAPIService extends BaseAPIService
{
    const ERROR_API_RESPONSE = 'error_api_response';

    public static function getBaseUrl() : string
    {
        return 'https://api.blockchain.com/v3/exchange';
    }

    public function getTickersBySymbols(string $symbolFrom, string $symbolTo) : Collection|string
    {
        $symbolFrom = strtoupper($symbolFrom);
        $symbolTo = strtoupper($symbolTo);
        try {
            $request = $this->http->get(self::generateEndpoint("tickers/$symbolFrom-$symbolTo"));

            $response = json_decode($request->getBody()->getContents());

            return is_object($response) && property_exists($response, 'symbol') && property_exists($response, 'price_24h')
                ? collect(
                    [
                        strtolower($symbolFrom) => [
                            strtolower($symbolTo) => $response->price_24h
                        ]
                    ]
                )
                : self::ERROR_API_RESPONSE;
        } catch (\Exception $exception) {
            return self::ERROR_API_RESPONSE;
        }
    }
}
