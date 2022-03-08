<?php

namespace App\Repositories;

use App\Interfaces\TranzactionRepositoryInterface;
use App\Models\Tranzaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class TranzactionRepository implements TranzactionRepositoryInterface
{
    public bool $success = false;

    public function logTranzaction(array $tranzactionDetails)
    {
        return Tranzaction::create($tranzactionDetails);
    }




    public function getClientMonthlyAmounts($client_id, $year, $month): Collection
    {
        $result = Tranzaction::where('client_id', $client_id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        if ($result) {
            $this->success = true;
        } else {
            $this->success = false;
        }
        return $result;
    }
}
