<?php

namespace Tests\Unit;

use App\Services\CurrencyExchangeRateService;
use PHPUnit\Framework\TestCase;

class CurrencyConversionTest extends TestCase
{

    /**
     * Exchange rate API Currency conversion test.
     *
     * @return void
     */
    public function test_currencyConversion()
    {
        $data = [];
        $data['date'] = '2021-01-01';
        $data['amount'] = 200.40;
        $data['currency'] = 'USD';
        $result = (new CurrencyExchangeRateService())->exchangeToEurCurrency($data['date'], $data['currency'], $data['amount']);

        $this->assertNotEquals($data['amount'], $result['amount']);
        $this->assertNotSame($data['currency'], $result['currency']);
    }
}
