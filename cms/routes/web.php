<?php

use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\AlbumController;
use App\Http\Controllers\Site\ArchiveSubmissionController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\EventController;
use App\Http\Controllers\Site\FamilyTreePageController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\NewsletterController;
use App\Http\Controllers\Site\PersonalityController;
use App\Http\Controllers\Site\SiteSearchController;
use App\Http\Controllers\Site\SocialController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/about', AboutController::class)->name('about');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/social', SocialController::class)->name('social');

Route::get('/family-tree', FamilyTreePageController::class)->name('family-tree');

Route::get('/personalities', PersonalityController::class)->name('personalities');

Route::get('/album', AlbumController::class)->name('album');

Route::permanentRedirect('/collections', '/');

Route::get('/search', SiteSearchController::class)->name('search');

Route::middleware('throttle:20,1')->group(function () {
    Route::post('/newsletter', NewsletterController::class)->name('newsletter.store');
    Route::post('/contact', ContactController::class)->name('contact.store');
    Route::post('/archive-submissions', ArchiveSubmissionController::class)->name('archive-submissions.store');
});

$htmlRedirects = [
    'index.html' => '/',
    'about.html' => '/about',
    'news.html' => '/news',
    'events.html' => '/events',
    'social.html' => '/social',
    'family-tree.html' => '/family-tree',
    'personalities.html' => '/personalities',
    'album.html' => '/album',
    'collections.html' => '/',
    'informations.html' => '/',
];

foreach ($htmlRedirects as $file => $path) {
    Route::permanentRedirect($file, $path);
}
