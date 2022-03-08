<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TranzactionRequest;
use App\Services\TranzactionService;
use Illuminate\Http\JsonResponse;
use App\Services\CommissionCalculation\CommissionCalculation;
use Carbon\Carbon;

class ApiController extends Controller
{
    private $tranzactionService;
    private $commissionCalculation;

    public function __construct(TranzactionService $tranzactionService, CommissionCalculation $commissionCalculation)
    {
        $this->tranzactionService = $tranzactionService;
        $this->commissionCalculation = $commissionCalculation;
    }


    /**
     * Get API request from user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function tranzactionRequest(TranzactionRequest $request)
    {
        try {
            $tranzaction['date'] = $request->date;
            $tranzaction['amount'] = $request->amount;
            $tranzaction['currency'] = $request->currency;
            $tranzaction['client_id'] = $request->client_id;
            // Expand tranzaction by adding direct date attributes
            $tranzaction['year'] = Carbon::parse($tranzaction['date'])->year;
            $tranzaction['month'] = Carbon::parse($tranzaction['date'])->format('m');
            $tranzaction['day'] = Carbon::parse($tranzaction['date'])->format('d');
            // Check currency of tranzaction
            $tranzaction = $this->tranzactionService->checkCurrencyInTranzaction($tranzaction);
            // Save tranzaction in a database
            $this->tranzactionService->saveTranzaction($tranzaction);
            // Calculate commissions on this tranzaction
            $response = $this->commissionCalculation->calculateCommission($tranzaction);
            if ($response) {
                //                return response()->json(['success' => true, 'data' => $response]); // Test only
                return response()->json($response);
            }
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Request failed: ' . $e->getMessage()]);
        }
    }
}
