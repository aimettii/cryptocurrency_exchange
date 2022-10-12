<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\BaseRepository;

class CurrencyRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'symbol'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Currency::class;
    }

    public function findBySymbol(string $symbol)
    {
        $query = $this->model->newQuery();

        return $query->where('symbol', strtolower($symbol))->first();
    }
}
