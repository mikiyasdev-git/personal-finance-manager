<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ReportRepositoryInterface
{
    public function getSummary(int $userId): array;

    public function getTransactionsReport(int $userId): Collection;
}
