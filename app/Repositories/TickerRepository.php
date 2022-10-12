<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Models\Ticker;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TickerRepository extends BaseRepository
{
    protected $currencyRepository;

    protected $fieldSearchable = [
        'currency_from',
        'currency_to',
        'rate'
    ];

    public function __construct()
    {
        parent::__construct();

        $this->currencyRepository = app()->make(CurrencyRepository::class);
    }

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Ticker::class;
    }

    public function create($input) : Model
    {
        foreach (['currency_from' => $input['currency_from'], 'currency_to' => $input['currency_to']] as $key => $currencySymbol) {
            $currency = $this->currencyRepository->findBySymbol($currencySymbol);

            if (!$currency) {
                $input[$key] = $this->currencyRepository->create([
                    'symbol' => $currencySymbol
                ])->id;
            } else {
                $input[$key] = $currency->id;
            }
        }

        return parent::create($input);
    }

    public function allQuery(array $search = [], int $skip = null, int $limit = null)
    {
        $query = QueryBuilder::for(parent::allQuery(...func_get_args()))->allowedFilters(
            [
                AllowedFilter::callback('currency', function (Builder $query, $value) {
                    $query->whereHas('currencyFrom', function($query) use ($value) {
                        return $query->where('symbol', strtolower($value));
                    });
                })
            ]
        );

        $query->actualCurrencyPairs();

        return $query;
    }

    public function getActualPair(Currency $currencyFrom, Currency $currencyTo)
    {
        $query = $this->model->newQuery();

        return $query->actualCurrencyPairs()->currenciesPair($currencyFrom, $currencyTo)->first();
    }

    public function disactiveForPair(Ticker $ticker, array $excludeIds = [])
    {
        $query = $this->model->newQuery();

        $query
            ->currenciesPair($ticker->currencyFrom, $ticker->currencyTo)
            ->whereNotIn('id', $excludeIds);

        return $query->update([
            'is_active' => false
        ]);
    }

    public function deleteCurrenenciesPair(Currency $currencyFrom, Currency $currencyTo)
    {
        $query = $this->model->newQuery();

        return $query->currenciesPair($currencyFrom, $currencyTo)->delete();
    }
}
