<?php

namespace App\Services;

use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountService
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository
    ) {
    }

    public function getAll(int $userId): Collection
    {
        return $this->accountRepository->getAllByUser($userId);
    }

    public function getById(int $id, int $userId): Account
    {
        $account = $this->accountRepository->findById($id, $userId);

        if (!$account) {
            throw new ModelNotFoundException();
        }

        return $account;
    }

    public function create(int $userId, array $data): Account
    {
        $data['user_id'] = $userId;

        return $this->accountRepository->create($data);
    }

    public function update(
        int $id,
        int $userId,
        array $data
    ): Account {
        $account = $this->getById($id, $userId);

        return $this->accountRepository->update(
            $account,
            $data
        );
    }

    public function delete(int $id, int $userId): void
    {
        $account = $this->getById($id, $userId);

        $this->accountRepository->delete($account);
    }
}
