<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllByUser(int $userId): Collection
    {
        return Category::where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function findById(int $id, int $userId): ?Category
    {
        return Category::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->refresh();
    }

    public function delete(Category $category): bool
    {
        return (bool) $category->delete();
    }
}
