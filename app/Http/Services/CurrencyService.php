<?php
namespace App\Http\Services;
use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
class CurrencyService
{
    public function saveCurrencies($jsonData)
    {
        \Log::info('Save');
        $currencies = json_decode($jsonData, true);

        $baseCurrency = $currencies['base'];
        $rates = $currencies['rates'];

        foreach ($rates as $currencyName => $rate) {
            $currency = new Currency;
            $currency->name = $currencyName;
            $currency->rate = $rate;
            $currency->save();
        }
    }

    public function createTable(string $currency) {
        $currencies = Currency::where('name', $currency)->get();
        return $currencies;
    }


    public function getAll(): Collection {
        return Currency::all();
    }

    public function updateCurrencies() {
        
    }
}