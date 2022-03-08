<?php

namespace App\Services\CommissionCalculation;

class Rules
{
    private $answer = [];
    private $commissionAmount;
    private $percentage = 0.5;
    //    public Bool $success = false;
    public $rules_total = 3;

    /**
     * Rule: Default Pricing
     * @param array $tranzactionData
     * @return array
     */

    public function ruleDefaultPricing(array $tranzactionData): array
    {
        if (array_key_exists('error', $this->answer)) {
            $this->answer = [];
        }
        $commissionAmount = $this->calculatePercentage($tranzactionData['amount']);
        if ($commissionAmount >= 0.05) {
            $this->answer['commission_amount'] = $commissionAmount;
            $this->answer['commission_currency'] = 'EUR';
            //            $this->success = true;
        } else {
            //            $this->success = false;
            $this->answer['error'] = true;
        }
        return $this->answer;
    }

    /**
     * Rule: Client With Discount
     * @param array $tranzactionData
     * @return array
     */

    public function ruleClientWithDiscount(array $tranzactionData): array
    {
        if (array_key_exists('error', $this->answer)) {
            $this->answer = [];
        }
        if ($tranzactionData['client_id'] == 42) {
            $commissionAmount = 0.05;
            $this->answer['commission_amount'] = $commissionAmount;
            $this->answer['commission_currency'] = 'EUR';
            //            $this->success = true;
        } else {
            //            $this->success = false;
            $this->answer['error'] = true;
        }
        return $this->answer;
    }

    /**
     * Rule: High turnover discount
     * @param array $tranzactionData
     * @return array
     */

    public function ruleTurnoverDiscount(array $tranzactionData): array
    {
        if (array_key_exists('error', $this->answer)) {
            $this->answer = [];
        }
        if ($tranzactionData['turnover']) {
            $commissionAmount = 0.03;
            $this->answer['commission_amount'] = $commissionAmount;
            $this->answer['commission_currency'] = 'EUR';
            //            $this->success = true;
        } else {
            $this->answer['error'] = true;
            ///            $this->success = false;
        }
        return $this->answer;
    }

    /**
     * Find X % of the amount as per default price
     * @param float $total
     * @return float
     */



    private function calculatePercentage(float $total): float
    {
        $result = ($this->percentage / 100) * $total;
        return number_format((float)$result, 2, '.', '');
    }
}
