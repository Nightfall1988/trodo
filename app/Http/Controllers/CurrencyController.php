<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ApiService;
use App\Http\Services\CurrencyService;
use App\Models\Currency;
use App\Models\Kal;

class CurrencyController extends Controller
{
    public ApiService $apiService;
    public CurrencyService $currencyService;

    public function __construct(ApiService $apiService, CurrencyService $currencyService) {
        $this->apiService = $apiService;
        $this->currencyService = $currencyService;
    }

    public function index() {
        if (Currency::exists()) {
            $currencies = $this->currencyService->getAll();
            return view('currency-exchange', ['currencies' => $currencies]);
        } else {
            $this->updateCurrencies();
            $currencies = $this->currencyService->getAll();
            return view('currency-exchange', ['currencies' => $currencies]);
        }
    }

    public function showTable(string $currency = 'USD') {
        return $this->currencyService->createTable($currency);
    }

    public function updateCurrencies() {
        $jsonData = $this->apiService->updateCurrencies();
        $this->currencyService->saveCurrencies($jsonData);
    }

    public function getPaginatedData(string $currency)
    {
        $data = Currency::where('name', '=', $currency);
        return response()->json($data);
    }

}
