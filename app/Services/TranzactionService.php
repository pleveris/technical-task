<?php

namespace App\Services;

use App\Interfaces\ApiCurrencyRateInterface;
use App\Interfaces\TranzactionRepositoryInterface;

class TranzactionService
{
    private ApiCurrencyRateInterface $exchangeRateApi;
    private TranzactionRepositoryInterface $tranzactionRepository;

    public function __construct(
        ApiCurrencyRateInterface $exchangeRateApi,
        TranzactionRepositoryInterface $tranzactionRepository
    ) {
        $this->exchangeRateApi = $exchangeRateApi;
        $this->tranzactionRepository = $tranzactionRepository;
    }

    public function checkCurrencyInTranzaction($tranzaction): array
    {
        if ($tranzaction['currency'] != 'EUR') {
            $date = $this->extractDate($tranzaction);
            $currency = $tranzaction['currency'];
            $amount = $tranzaction['amount'];
            $conversion = [];
            $conversion = $this->exchangeRateApi->exchangeToEurCurrency($date, $currency, $amount);
            if ($conversion['amount'] > 0) {
                $tranzaction['currency'] = 'EUR';
                $tranzaction['amount'] = $conversion['amount'];
            }
        }
        return $tranzaction;
    }

    public function saveTranzaction(array $tranzaction)
    {
        $this->tranzactionRepository->logTranzaction($tranzaction);
    }




    private function extractDate($tranzaction): string
    {
        $data = $tranzaction['year'] . '-' . $tranzaction['month'] . '-' . $tranzaction['day'];

        return $data;
    }
}
