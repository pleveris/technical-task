<?php

namespace App\Interfaces;

interface TranzactionRepositoryInterface
{
    public function logTranzaction(array $tranzactionDetails);
    public function getClientMonthlyAmounts($client_id, $year, $month);
}
