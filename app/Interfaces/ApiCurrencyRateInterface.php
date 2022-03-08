<?php

namespace App\Interfaces;

interface ApiCurrencyRateInterface
{
    public function exchangeToEurCurrency(string $date, string $currency, float $amount);
}
