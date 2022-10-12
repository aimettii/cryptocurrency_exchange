<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\ExchangeAPICollection;
use App\Facades\Blockchain;
use App\Facades\Coingecko;
use App\Models\Ticker;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FindTickers extends Command
{
    use ExchangeAPICollection;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickers:find {currency_from} {currency_to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find currency rates in third-party API services';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tickersExchangesResults = $this->findTickersCollections($this->argument('currency_from'), $this->argument('currency_to'))->map(function($item) {
            $item['exchange_name'] = sprintf("%s API", self::getApiNames($item['exchange_name']));
            $item['currency_from'] = sprintf("1 %s", strtoupper($this->argument('currency_from')));
            $item['currency_to'] = sprintf("%s %s", $item['rate'], strtoupper($this->argument('currency_to')));
            return $item;
        });

        if ($tickersExchangesResults->isEmpty()) {
            $this->error('---------NOT FOUND----------');
            return Command::FAILURE;
        } else {
            $this->info('---------FOUNDED----------');
            $this->info(
                sprintf(
                    "Symbol: %s/%s",
                    strtoupper($this->argument('currency_from')),
                    strtoupper($this->argument('currency_to'))
                )
            );
            $this->table(
                ['Exchange', strtoupper($this->argument('currency_from')), strtoupper($this->argument('currency_to'))],
                $tickersExchangesResults->map(function($item) {
                    return [
                      $item['exchange_name'],
                      $item['currency_from'],
                      $item['currency_to'],
                    ];
                })->all()
            );
        }

        return Command::SUCCESS;
    }
}
