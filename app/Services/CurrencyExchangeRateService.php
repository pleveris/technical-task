<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Interfaces\ApiCurrencyRateInterface;

class CurrencyExchangeRateService implements ApiCurrencyRateInterface
{
    private $uri = 'https://api.exchangerate.host/convert?';
    private $uriParamFrom;
    private $uriParamTo;
    private $uriParamDate;
    private $uriParamBase;
    private $uriParamAmount;
    private $uriParamPlaces;
    /**
     * @param string $date
     * @param string $currency
     * @param Float $amount
     * @return array
     */

    public function exchangeToEurCurrency(string $date, string $currency, float $amount): array
    {
        $this->uriParamFrom = "from=" . $currency;
        $this->uriParamTo = "&to=EUR";
        $this->uriParamDate = "&date=" . $date;
        $this->uriParamBase = "&base=" . $currency;
        $this->uriParamAmount = "&amount=" . $amount;
        $this->uriParamPlaces = "&places=2";

        $message = "Couldn't get exchange rate";
        $exchangeRate = null;

        $client = new Client();

        try {
            $request = $client->get(
                $this->uri . $this->uriParamFrom . $this->uriParamTo
                    . $this->uriParamDate . $this->uriParamBase . $this->uriParamAmount . $this->uriParamPlaces
            );
            $response = json_decode($request->getBody(), true);
        } catch (ClientException $e) {
            $response = [
                "error" => $message,
            ];
        }

        if (!isset($response['error'])) {
            $exchangeRate = $response["result"];
        }
        $result = [];
        $result['amount'] = $exchangeRate;
        if (isset($response['error'])) {
            $result['error'] = $response['error'];
        }
        return $result;
    }
}
