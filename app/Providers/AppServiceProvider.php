<?php

namespace App\Providers;

use App\Http\Controllers\Client\MenuController;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $menuCategories = (new MenuController())->getCategoriesForMenu();
            $view->with('menuCategories', $menuCategories);
        });

        Paginator::useBootstrapFive();
    }
}
