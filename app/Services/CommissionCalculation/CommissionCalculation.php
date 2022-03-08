<?php

namespace App\Services\CommissionCalculation;

use App\Services\CommissionCalculation\Rules;
use App\Interfaces\TranzactionRepositoryInterface;

class CommissionCalculation extends Rules
{
    private TranzactionRepositoryInterface $tranzactionRepository;
    private $result = [];
    private float $total_amount = 0.0;
    private $tranzaction = [];


    public function __construct(TranzactionRepositoryInterface $tranzactionRepository)
    {
        $this->tranzactionRepository = $tranzactionRepository;
    }


    /**
     * Calculate commission
     *
     * @param array $tranzaction
     * @return array
     */

    public function calculateCommission(array $tranzaction): array
    {
        $response = [];
        $temp = [];
        $this->tranzaction = $tranzaction;
        // Checking for allowed calculation rules, valid rules are applied
        for ($i = 1; $i <= $this->rules_total; $i++) {
            $currentRule = 0;
            $currentRule = $this->checkRule($i);
            if ($currentRule > 0) {
                $temp = $this->applyRule($currentRule, $tranzaction);
            }
            if ($temp && !array_key_exists('error', $temp)) {
                array_push($response, $temp);
            }
            $temp = [];
        }
        if ($response) {
            array_multisort(array_column($response, 'commission_amount'), SORT_NUMERIC, $response);
        }
        return $response[0];
    }

    /**
     * Check which commission calculation rules could be applied
     * @param int $num
     * @return int
     */

    private function checkRule(int $num): int
    {
        switch ($num) {
            case 1:
                return $num; // Certain check for rule 1 is not needed as it is always valid
                break;

            case 2:
                if ($this->tranzaction['client_id'] == 42) {
                    return $num;
                } else {
                    return 0;
                }
                break;

            case 3:
                $result = $this->tranzactionRepository->getClientMonthlyAmounts(
                    $this->tranzaction['client_id'],
                    $this->tranzaction['year'],
                    $this->tranzaction['month']
                );
                if ($this->tranzactionRepository->success) {
                    foreach ($result as $value) {
                        $this->total_amount += $value->amount;
                    }
                    $this->total_amount -= $this->tranzaction['amount'];
                    // We should exclude amount of the last tranzaction to make sure there is no turnover before it
                    if ((int)$this->total_amount >= 1000) {  // All the conditions are met, rule is valid
                        $this->total_amount = 0.0;
                        return $num;
                    } else {
                        return 0;
                    }
                }
                break;
        }
    }

    /**
     * Apply commission calculation rules
     * @param int $num, number of a rule to apply
     * @return array
     */


    private function applyRule(int $num): array
    {
        switch ($num) {
            case 1:
                $result = $this->ruleDefaultPricing($this->tranzaction);
                return $result;
                break;

            case 2:
                $result = $this->ruleClientWithDiscount($this->tranzaction);
                return $result;
                break;
            case 3:
                $this->tranzaction['turnover'] = true;
                $result = $this->ruleTurnoverDiscount($this->tranzaction);
                return $result;
                break;
        }
    }
}
