<?php

namespace App\Repositories;

use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository implements AccountRepositoryInterface
{
    public function getAllByUser(int $userId): Collection
    {
        return Account::where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function findById(int $id, int $userId): ?Account
    {
        return Account::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function create(array $data): Account
    {
        return Account::create($data);
    }

    public function update(Account $account, array $data): Account
    {
        $account->update($data);

        return $account->refresh();
    }

    public function delete(Account $account): bool
    {
        return (bool) $account->delete();
    }
}
