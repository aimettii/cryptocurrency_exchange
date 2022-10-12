<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\ExchangeAPICollection;
use App\Models\Ticker;
use App\Repositories\TickerRepository;
use Illuminate\Console\Command;

class CreateTicker extends Command
{
    use ExchangeAPICollection;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickers:create {currency_from} {currency_to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save currency tickers from third-party sources to our database ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TickerRepository $tickerRepository)
    {
        $tickersExchangesResults = $this->findTickersCollections($this->argument('currency_from'), $this->argument('currency_to'))->map(function($item) {
            $item['exchange_name_visible'] = sprintf("%s API", self::getApiNames($item['exchange_name']));
            $item['currency_from'] = sprintf("1 %s", strtoupper($this->argument('currency_from')));
            $item['currency_to'] = sprintf("%s %s", $item['rate'], strtoupper($this->argument('currency_to')));
            return $item;
        });;

        if ($tickersExchangesResults->isEmpty()) {
            $this->error('---------NOT FOUND----------');
            return Command::FAILURE;
        } else {
            $this->info('---------FOUNDED----------');

            $choises = collect($tickersExchangesResults)->map(function($item) {
                return "{$item['exchange_name_visible']} - {$item['currency_from']}/{$item['currency_to']}";
            })->push("Save all")->all();
            $choisesLastIndex = key(array_slice($choises, -1, 1, true));

            $choisedIndex = array_search(
                $this->choice(
                    'Which source to save in our system?',
                    $choises,
                    $choisesLastIndex
                ), $choises);

            $canSaveTickers = $choisedIndex === $choisesLastIndex ? $tickersExchangesResults : $tickersExchangesResults->slice($choisedIndex, 1);

            $successSaved = collect();
            $failureSaved = collect();

            $canSaveTickers->each(function ($ticker) use ($tickerRepository, &$successSaved, &$failureSaved) {
                $savedTicker = $tickerRepository->create([
                    'api' => $ticker['exchange_name'],
                    'tax' => Ticker::DEFAULT_TAX_PERCENT,
                    'rate' => $ticker['rate'],
                    'currency_from' => $this->argument('currency_from'),
                    'currency_to' => $this->argument('currency_to'),
                    'is_active' => true,
                ]);

                if ($savedTicker->exists) {
                    $successSaved->push($savedTicker);
                } else {
                    $failureSaved->push($savedTicker);
                }
            });

            if ($successSaved->count() > 0) {
                $tickerRepository->disactiveForPair($successSaved->first(), $successSaved->pluck('id')->all());
                $this->info(sprintf("Saved %s new tickers", $successSaved->count()));
            }

            if ($failureSaved->count() > 0) {
                $this->info(sprintf("Error when attempt of the save: %s", $failureSaved->count()));
            }

        }

        return Command::SUCCESS;
    }
}
