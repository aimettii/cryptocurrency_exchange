<?php

namespace App\Services\CoingeckoAPI;

use App\Services\Base\BaseAPIService;
use Illuminate\Support\Collection;

class CoingeckoAPIService extends BaseAPIService
{
    const ERROR_NOT_FOUND_IDENTIFIER = 'error_not_found_indentifier';
    const ERROR_API_RESPONSE = 'error_api_response';
    const ERROR_NOT_FOUND_SYMBOL = 'error_not_found_symbol';

    public static function getBaseUrl() : string
    {
        return 'https://api.coingecko.com/api/v3';
    }

    public function getTickersBySymbols(string|array $symbolFrom, string|array $symbolTo) : Collection|string
    {
        $symbolFrom = collect($symbolFrom)->map(function ($item) {
            return strtolower($item);
        })->toArray();
        $symbolFrom = collect(self::findNameIdentifierBySymbol($symbolFrom))->filter(function($item) {
            return !!$item;
        });
        $symbolTo = collect($symbolTo)->map(function ($item) {
            return strtolower($item);
        });

        if ($symbolFrom->isEmpty() || $symbolTo->isEmpty()) {
            return self::ERROR_NOT_FOUND_IDENTIFIER;
        }

        $symbolFromQuery = $symbolFrom->implode(',');
        $symbolToQuery = $symbolTo->implode(',');

        try {
            $request = $this->http->get(self::generateEndpoint('simple/price'), [
                'query' => [
                    'ids' => $symbolFromQuery,
                    'vs_currencies' => $symbolToQuery
                ]
            ]);

            $response = json_decode($request->getBody()->getContents());

            return is_object($response) && $symbolFrom->filter(function ($item) use ($response) {
                return property_exists($response, $item) && is_object($response->{$item}) && !empty((array) $response->{$item});
            })->isNotEmpty()
                ? $symbolFrom->map(function($item) use ($response) {
                    return property_exists($response, $item) && is_object($response->{$item}) && !empty((array) $response->{$item})
                        ? collect(json_decode(json_encode($response->{$item}), true))->map(function($item) {
                            // Check on exponentiate E-5
                            if (!preg_match("/^\-?[0-9]*\.?[0-9]+\z/", $item)) {
                                return rtrim(number_format($item, 10), '0');
                            }
                            return $item;
                        })->all()
                        : self::ERROR_NOT_FOUND_SYMBOL;
                })
                : self::ERROR_API_RESPONSE;
        } catch (\Exception $exception) {
            return self::ERROR_API_RESPONSE;
        }
    }

    private static function findNameIdentifierBySymbol(string|array $symbol) : Collection|bool
    {
        try {
            $content = file_get_contents(resource_path('coins.json'));

            $coinsData = collect(json_decode($content, true));
        } catch (\Exception $exception) {
            return false;
        }

        $coinsData = $coinsData->filter(function($item) {
            return isset($item['id']) && isset($item['symbol']);
        })->whereIn('symbol', is_array($symbol) ? $symbol : [$symbol])->unique('symbol')->mapWithKeys(function ($coin) {
            return [$coin['symbol'] => $coin['id']];
        });

        return $coinsData;
    }
}
