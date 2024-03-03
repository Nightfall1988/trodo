<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\CurrencyService;
use App\Http\Services\ApiService;
use App\Http\Controllers\CurrencyController;
use App\Models\Currency;

class UpdateCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the currencies table with latest rates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public ApiService $apiService;
    public CurrencyService $currencyService;

    public function __construct(ApiService $apiService, CurrencyService $currencyService) 
    {
        parent::__construct();
        $this->apiService = $apiService;
        $this->currencyService = $currencyService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->updateCurrencies();
        return 0;
    }

    public function updateCurrencies() {
        $jsonData = $this->apiService->updateCurrencies();
        $this->currencyService->saveCurrencies($jsonData);
    }
}
