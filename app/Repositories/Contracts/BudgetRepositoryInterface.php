<?php

namespace App\Repositories\Contracts;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Collection;

interface BudgetRepositoryInterface
{
    public function getAll(int $userId): Collection;

    public function findById(int $id, int $userId): Budget;

    public function create(array $data): Budget;

    public function update(int $id, int $userId, array $data): Budget;

    public function delete(int $id, int $userId): bool;
}
