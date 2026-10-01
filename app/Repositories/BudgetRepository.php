<?php

namespace App\Repositories;

use App\Models\Budget;
use App\Repositories\Contracts\BudgetRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BudgetRepository implements BudgetRepositoryInterface
{
    public function getAll(int $userId): Collection
    {
        return Budget::with('category')
            ->where('user_id', $userId)
            ->latest('month')
            ->get();
    }

    public function findById(int $id, int $userId): Budget
    {
        return Budget::with('category')
            ->where('user_id', $userId)
            ->findOrFail($id);
    }

    public function create(array $data): Budget
    {
        return Budget::create($data);
    }

    public function update(
        int $id,
        int $userId,
        array $data
    ): Budget {
        $budget = $this->findById($id, $userId);

        $budget->update($data);

        return $budget->fresh('category');
    }

    public function delete(int $id, int $userId): bool
    {
        $budget = $this->findById($id, $userId);

        return (bool) $budget->delete();
    }
}
