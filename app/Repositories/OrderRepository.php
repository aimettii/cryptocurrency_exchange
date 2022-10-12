<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class OrderRepository extends BaseRepository
{
    protected $currencyRepository;
    protected $tickerRepository;

    protected $fieldSearchable = [
        'currency_from',
        'currency_to',
        'value',
        'converted_value',
        'rate'
    ];

    public function __construct()
    {
        parent::__construct();

        $this->currencyRepository = app()->make(CurrencyRepository::class);
        $this->tickerRepository = app()->make(TickerRepository::class);
    }

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Order::class;
    }

    public function create($input) : Model
    {
        $currenciesModels = [];

        foreach (['currency_from' => $input['currency_from'], 'currency_to' => $input['currency_to']] as $key => $currencySymbol) {
            $currency = $this->currencyRepository->findBySymbol($currencySymbol);

            if ($currency) {
                $input[$key] = $currency->id;
                $currenciesModels[$key] = $currency;
            } else {
               throw new \InvalidArgumentException('Bad currencies given');
            }
        }

        $ticker = $this->tickerRepository->getActualPair($currenciesModels['currency_from'], $currenciesModels['currency_to']);

        if (!$ticker) {
            throw new \InvalidArgumentException('Not found currency pair given');
        }

        $input['value'] = $input['value'] * 1;
        $input['converted_value'] = $ticker->formatted_rate * $input['value'];
        $input['rate'] = $ticker->formatted_rate;

        return parent::create($input);
    }
}
