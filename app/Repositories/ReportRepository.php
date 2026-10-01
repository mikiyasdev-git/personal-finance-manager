<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Contracts\ReportRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    public function getSummary(int $userId): array
    {
        $query = Transaction::where('user_id', $userId);

        $totalIncome = (clone $query)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = (clone $query)
            ->where('type', 'expense')
            ->sum('amount');

        return [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $totalIncome - $totalExpense,
            'transaction_count' => $query->count(),
        ];
    }

    public function getTransactionsReport(int $userId): Collection
    {
        return Transaction::with([
            'account',
            'category',
        ])
            ->where('user_id', $userId)
            ->latest('transaction_date')
            ->get();
    }
}
