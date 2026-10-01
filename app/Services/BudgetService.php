<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Category;
use App\Repositories\Contracts\BudgetRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BudgetService
{
    public function __construct(
        protected BudgetRepositoryInterface $budgetRepository
    ) {
    }

    public function getAll(int $userId): Collection
    {
        return $this->budgetRepository->getAll($userId);
    }

    public function getById(int $id, int $userId): Budget
    {
        return $this->budgetRepository->findById(
            $id,
            $userId
        );
    }

    public function create(
        int $userId,
        array $data
    ): Budget {
        Category::where('id', $data['category_id'])
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->firstOrFail();

        $data['user_id'] = $userId;

        return $this->budgetRepository->create($data);
    }

    public function update(
        int $id,
        int $userId,
        array $data
    ): Budget {
        if (isset($data['category_id'])) {
            Category::where('id', $data['category_id'])
                ->where('user_id', $userId)
                ->where('type', 'expense')
                ->firstOrFail();
        }

        return $this->budgetRepository->update(
            $id,
            $userId,
            $data
        );
    }

    public function delete(
        int $id,
        int $userId
    ): bool {
        return $this->budgetRepository->delete(
            $id,
            $userId
        );
    }
}
