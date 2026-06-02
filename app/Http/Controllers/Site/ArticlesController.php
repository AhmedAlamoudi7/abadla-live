<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\NewsPost;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = 12;

        // Primary source: the dedicated articles table.
        // Respect the "published" toggle; a missing date means "publish now"
        // (only genuinely future-dated articles are hidden).
        $items = collect();
        if (Schema::hasTable('articles')) {
            $items = Article::query()
                ->where('published', true)
                ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()))
                ->orderByDesc('published_at')
                ->get();
        }

        // Backward-compatible fallback: surface any articles that still live in
        // news_posts (e.g. when the data migration hasn't run on this server yet).
        // Once everything is migrated, this query simply returns nothing.
        if (Schema::hasColumn('news_posts', 'type')) {
            $legacy = NewsPost::query()
                ->where('type', NewsPost::TYPE_ARTICLE)
                ->where('published', true)
                ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()))
                ->orderByDesc('published_at')
                ->get();

            $items = $items->concat($legacy)
                ->unique('slug')
                ->sortByDesc('published_at')
                ->values();
        }

        $page = LengthAwarePaginator::resolveCurrentPage();
        $articles = new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('site.articles.index', [
            'activeNav' => 'news',
            'title' => Setting::getValue('articles_meta_title', 'مقالات - العبادلة'),
            'metaDescription' => Setting::getValue('articles_meta_description', 'مقالات عائلة العبادلة.'),
            'articles' => $articles,
        ]);
    }
}
