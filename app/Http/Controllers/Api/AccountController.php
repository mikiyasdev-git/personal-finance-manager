<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\AccountResource;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AccountController extends Controller
{
    public function __construct(
        private AccountService $accountService
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection {
        $accounts = $this->accountService->getAll(
            $request->user()->id
        );

        return AccountResource::collection($accounts);
    }

    public function store(StoreAccountRequest $request ): AccountResource {
        $account = $this->accountService->create(
            $request->user()->id,
            $request->validated()
        );

        return new AccountResource($account);
    }

    public function show(Request $request, int $account): AccountResource {
        $account = $this->accountService->getById(
            $account,
            $request->user()->id
        );

        return new AccountResource($account);
    }

    public function update(UpdateAccountRequest $request, int $account
    ): AccountResource {
        $account = $this->accountService->update(
            $account,
            $request->user()->id,
            $request->validated()
        );

        return new AccountResource($account);
    }

    public function destroy(Request $request, int $account
    ): JsonResponse {
        $this->accountService->delete(
            $account,
            $request->user()->id
        );

        return response()->json([
            'message' => 'Account deleted successfully.',
        ]);
    }
}
