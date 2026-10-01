<?php
namespace App\Services;
use App\Repositories\Contracts\ReportRepositoryInterface;
use Illuminate\Support\Collection;

class ReportService
{
    public function __construct(
        protected ReportRepositoryInterface $reportRepository )
        {

        }
         public function getSummary(int $userId): array
         {
            return $this->reportRepository->getSummary($userId);
        }
        public function getTransactionsReport(int $userId): Collection
        {
            return $this->reportRepository->getTransactionsReport($userId);
        }
}
