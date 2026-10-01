<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getAllByUser(int $userId): Collection
    {
        return Transaction::query()
            ->where('user_id', $userId)
            ->orderByDesc('transaction_date')
            ->orderByDesc('created_at')
            ->get();
    }

    public function findByIdForUser(
        int $transactionId,
        int $userId
    ): Transaction {
        return Transaction::query()
            ->where('id', $transactionId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function update(
        Transaction $transaction,
        array $data
    ): Transaction {
        $transaction->update($data);

        return $transaction->refresh();
    }

    public function delete(Transaction $transaction): void
    {
        $transaction->delete();
    }

    public function accountBelongsToUser(
        int $accountId,
        int $userId
    ): bool {
        return Account::query()
            ->where('id', $accountId)
            ->where('user_id', $userId)
            ->exists();
    }

    public function categoryBelongsToUser(
        int $categoryId,
        int $userId
    ): bool {
        return Category::query()
            ->where('id', $categoryId)
            ->where('user_id', $userId)
            ->exists();
    }
}
