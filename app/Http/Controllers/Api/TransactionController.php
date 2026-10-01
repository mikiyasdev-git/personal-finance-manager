<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        $userId = (int) Auth::id();

        $transactions = $this->transactionService->getAll($userId);

        return TransactionResource::collection($transactions);
    }

    public function store(
        StoreTransactionRequest $request
    ): TransactionResource {
        $userId = (int) Auth::id();

        $transaction = $this->transactionService->create(
            $userId,
            $request->validated()
        );

        return new TransactionResource($transaction);
    }

    public function show(int $transaction): TransactionResource
    {
        $userId = (int) Auth::id();

        $transactionModel = $this->transactionService->getById(
            $transaction,
            $userId
        );

        return new TransactionResource($transactionModel);
    }

    public function update(
        UpdateTransactionRequest $request,
        int $transaction
    ): TransactionResource {
        $userId = (int) Auth::id();

        $updatedTransaction = $this->transactionService->update(
            $transaction,
            $userId,
            $request->validated()
        );

        return new TransactionResource($updatedTransaction);
    }

    public function destroy(int $transaction): JsonResponse
    {
        $userId = (int) Auth::id();

        $this->transactionService->delete(
            $transaction,
            $userId
        );

        return response()->json([
            'message' => 'Transaction deleted successfully.',
        ]);
    }
}
