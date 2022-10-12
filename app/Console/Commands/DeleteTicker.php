<?php

namespace App\Console\Commands;

use App\Repositories\CurrencyRepository;
use App\Repositories\TickerRepository;
use Illuminate\Console\Command;

class DeleteTicker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickers:delete {currency_from} {currency_to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete currency pair from our system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TickerRepository $tickerRepository, CurrencyRepository $currencyRepository)
    {
        $currencyFrom = $currencyRepository->findBySymbol($this->argument('currency_from'));
        $currencyTo = $currencyRepository->findBySymbol($this->argument('currency_to'));

        if (
            in_array(null, [$currencyFrom, $currencyTo])
            || $tickerRepository->all(['currency_from' => $currencyFrom->id, 'currency_to' => $currencyTo->id])->isEmpty()
        ) {
            $this->error('---------NOT FOUND CURRENCY PAIR----------');
            return Command::FAILURE;
        }

        $tickerRepository->deleteCurrenenciesPair($currencyFrom, $currencyTo);
        $this->info('---------Successfully deleted----------');

        return Command::SUCCESS;
    }
}
