<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AccountRepository;
use App\Repositories\BudgetRepository;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\BudgetRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\TransactionRepository;
use App\Repositories\ReportRepository;
use App\Repositories\Contracts\ReportRepositoryInterface;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AccountRepositoryInterface::class,
            AccountRepository::class
        );

        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class
        );
        $this->app->bind(
            BudgetRepositoryInterface::class,
            BudgetRepository::class
        );
        $this->app->bind(
            ReportRepositoryInterface::class,
            ReportRepository::class
        );
    }





    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
