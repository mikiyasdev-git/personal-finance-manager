<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function getAll(int $userId): Collection
    {
        return $this->categoryRepository->getAllByUser($userId);
    }

    public function getById(int $id, int $userId): Category
    {
        $category = $this->categoryRepository->findById($id, $userId);

        if (!$category) {
            throw new ModelNotFoundException('Category not found.');
        }

        return $category;
    }

    public function create(int $userId, array $data): Category
    {
        $data['user_id'] = $userId;

        return $this->categoryRepository->create($data);
    }

    public function update(
        int $id,
        int $userId,
        array $data
    ): Category {
        $category = $this->getById($id, $userId);

        return $this->categoryRepository->update(
            $category,
            $data
        );
    }

    public function delete(int $id, int $userId): bool
    {
        $category = $this->getById($id, $userId);

        return $this->categoryRepository->delete($category);
    }
}
