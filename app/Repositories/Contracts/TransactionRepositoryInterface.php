<?php

namespace App\Repositories\Contracts;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

interface TransactionRepositoryInterface
{
    public function getAllByUser(int $userId): Collection;

    public function findByIdForUser(
        int $transactionId,
        int $userId
    ): Transaction;

    public function create(array $data): Transaction;

    public function update(
        Transaction $transaction,
        array $data
    ): Transaction;

    public function delete(Transaction $transaction): void;

    public function accountBelongsToUser(
        int $accountId,
        int $userId
    ): bool;

    public function categoryBelongsToUser(
        int $categoryId,
        int $userId
    ): bool;
}
