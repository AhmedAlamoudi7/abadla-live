<?php

namespace App\Providers;

use App\View\Composers\SiteComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrapFive();

        View::composer('layouts.site', SiteComposer::class);

        Gate::before(fn ($user, string $ability) => $user->hasRole('super_admin') ? true : null);
    }
}
