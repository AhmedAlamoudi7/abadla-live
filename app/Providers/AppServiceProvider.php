<?php

namespace App\Providers;

use App\View\Composers\SiteComposer;
use Filament\Forms\Components\RichEditor;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
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
                    Schema::defaultStringLength(191);

        Paginator::useBootstrapFive();

        View::composer('layouts.site', SiteComposer::class);

        // Make every Filament RichEditor upload inserted/pasted images to the public
        // disk (served via storage:link) instead of leaving them as un-uploaded Trix
        // attachments that render only as "filename + size" text.
        RichEditor::configureUsing(function (RichEditor $component): void {
            $component
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('rich-attachments')
                ->fileAttachmentsVisibility('public');
        });

        Gate::before(fn ($user, string $ability) => $user->hasRole('super_admin') ? true : null);
    }
}
