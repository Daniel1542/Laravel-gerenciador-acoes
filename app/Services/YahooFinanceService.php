<?php

namespace App\Services;

use Scheb\YahooFinanceApi\ApiClientFactory;
use Scheb\YahooFinanceApi\ApiClient;

class YahooFinanceService
{
    protected $client;

    public function __construct()
    {
        $this->client = ApiClientFactory::createApiClient();
    }

    public function getStockPrice($symbol)
    {
        try {
            $quote = $this->client->getQuote($symbol);
            if ($quote) {
                return $quote->getRegularMarketPrice();
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
