<?php

namespace App\Providers;

use App\Http\Controllers\Client\MenuController;
use App\Http\View\Composers\OrderComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Đăng ký OrderComposer cho header
        View::composer('admin.layouts.header', OrderComposer::class);

        view()->composer('*', function ($view) {
            $menuCatalogues = (new MenuController())->getCataloguesForMenu();
            $view->with('menuCatalogues', $menuCatalogues);
        });

        view()->composer('*', function ($view) {
            $menuCategories = (new MenuController())->getCategoriesForMenu();
            $view->with('menuCategories', $menuCategories);
        });

        Paginator::useBootstrapFive();
    }
}
