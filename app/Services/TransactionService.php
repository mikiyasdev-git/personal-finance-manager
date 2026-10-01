<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class TransactionService
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function getAll(int $userId): Collection
    {
        return $this->transactionRepository->getAllByUser($userId);
    }

    public function getById(
        int $transactionId,
        int $userId
    ): Transaction {
        return $this->transactionRepository->findByIdForUser(
            $transactionId,
            $userId
        );
    }

    public function create(
        int $userId,
        array $data
    ): Transaction {
        $this->validateOwnership(
            $userId,
            $data['account_id'],
            $data['category_id']
        );

        $data['user_id'] = $userId;

        return $this->transactionRepository->create($data);
    }

    public function update(
        int $transactionId,
        int $userId,
        array $data
    ): Transaction {
        $transaction = $this->transactionRepository->findByIdForUser(
            $transactionId,
            $userId
        );

        $accountId = $data['account_id'] ?? $transaction->account_id;
        $categoryId = $data['category_id'] ?? $transaction->category_id;

        $this->validateOwnership(
            $userId,
            $accountId,
            $categoryId
        );

        return $this->transactionRepository->update(
            $transaction,
            $data
        );
    }

    public function delete(
        int $transactionId,
        int $userId
    ): void {
        $transaction = $this->transactionRepository->findByIdForUser(
            $transactionId,
            $userId
        );

        $this->transactionRepository->delete($transaction);
    }

    private function validateOwnership(
        int $userId,
        int $accountId,
        int $categoryId
    ): void {
        $accountBelongsToUser =
            $this->transactionRepository->accountBelongsToUser(
                $accountId,
                $userId
            );

        if (! $accountBelongsToUser) {
            throw new ModelNotFoundException(
                'Account not found.'
            );
        }

        $categoryBelongsToUser =
            $this->transactionRepository->categoryBelongsToUser(
                $categoryId,
                $userId
            );

        if (! $categoryBelongsToUser) {
            throw new ModelNotFoundException(
                'Category not found.'
            );
        }
    }
}
