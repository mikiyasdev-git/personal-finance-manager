<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {
    }

    public function summary(): JsonResponse
    {
        $userId = (int) Auth::id();

        return response()->json([
            'data' => $this->reportService->getSummary($userId),
        ]);
    }

    public function transactions(): AnonymousResourceCollection
    {
        $userId = (int) Auth::id();

        $transactions = $this->reportService
            ->getTransactionsReport($userId);

        return TransactionResource::collection($transactions);
    }
}
