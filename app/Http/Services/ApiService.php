<?php
namespace App\Http\Services;
use Illuminate\Http\Request;

class ApiService
{
    private string $apiUrl;

    public function __construct() {
        $this->apiUrl = env('API_BASE_URL') . 'EUR&apiKey=' . env('API_KEY');
    }

        public function updateCurrencies() {
            
        $httpClient = new \GuzzleHttp\Client();
        $request =
            $httpClient
                ->get($this->apiUrl);
        $response = $request->getBody()->getContents();
        return $response;
    }

}