<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;
use App\Http\Resources\BudgetResource;
use App\Services\BudgetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function __construct(
        protected BudgetService $budgetService
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        $userId = (int) Auth::id();

        $budgets = $this->budgetService->getAll($userId);

        return BudgetResource::collection($budgets);
    }

    public function store(StoreBudgetRequest $request): BudgetResource
    {
        $userId = (int) Auth::id();

        $budget = $this->budgetService->create(
            $userId,
            $request->validated()
        );

        return new BudgetResource($budget->load('category'));
    }

    public function show(int $id): BudgetResource
    {
        $userId = (int) Auth::id();

        $budget = $this->budgetService->getById(
            $id,
            $userId
        );

        return new BudgetResource($budget);
    }

    public function update(
        UpdateBudgetRequest $request,
        int $id
    ): BudgetResource {
        $userId = (int) Auth::id();

        $budget = $this->budgetService->update(
            $id,
            $userId,
            $request->validated()
        );

        return new BudgetResource($budget);
    }

    public function destroy(int $id): JsonResponse
    {
        $userId = (int) Auth::id();

        $this->budgetService->delete(
            $id,
            $userId
        );

        return response()->json([
            'message' => 'Budget deleted successfully.',
        ]);
    }
}
