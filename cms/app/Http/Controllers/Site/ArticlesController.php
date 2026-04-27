<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    public function index(Request $request): View
    {
        $articles = NewsPost::query()
            ->where('type', NewsPost::TYPE_ARTICLE)
            ->where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('site.articles.index', [
            'activeNav' => 'news',
            'title' => Setting::getValue('articles_meta_title', 'مقالات - العبادلة'),
            'metaDescription' => Setting::getValue('articles_meta_description', 'مقالات عائلة العبادلة.'),
            'articles' => $articles,
        ]);
    }
}
