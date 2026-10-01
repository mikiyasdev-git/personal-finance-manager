<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        $userId = (int) Auth::id();

        $categories = $this->categoryService->getAll($userId);

        return CategoryResource::collection($categories);
    }

    public function store(
        StoreCategoryRequest $request
    ): CategoryResource {
        $userId = (int) Auth::id();

        $category = $this->categoryService->create(
            $userId,
            $request->validated()
        );

        return new CategoryResource($category);
    }

    public function show(int $category): CategoryResource
    {
        $userId = (int) Auth::id();

        $categoryModel = $this->categoryService->getById(
            $category,
            $userId
        );

        return new CategoryResource($categoryModel);
    }

    public function update(
        UpdateCategoryRequest $request,
        int $category
    ): CategoryResource {
        $userId = (int) Auth::id();

        $updatedCategory = $this->categoryService->update(
            $category,
            $userId,
            $request->validated()
        );

        return new CategoryResource($updatedCategory);
    }

    public function destroy(int $category): JsonResponse
    {
        $userId = (int) Auth::id();

        $this->categoryService->delete(
            $category,
            $userId
        );

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }
}
