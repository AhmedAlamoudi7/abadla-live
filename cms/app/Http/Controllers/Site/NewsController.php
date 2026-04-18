<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\NewsBanner;
use App\Models\NewsPost;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = NewsPost::query()
            ->where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at');

        $news = $query->paginate(12)->withQueryString();

        $banners = NewsBanner::query()->where('is_active', true)->orderBy('slot')->get();

        return view('site.news.index', [
            'activeNav' => 'news',
            'title' => Setting::getValue('news_meta_title', 'أخبار العائلة - العبادلة'),
            'metaDescription' => Setting::getValue('news_meta_description', 'آخر أخبار عائلة العبادلة.'),
            'news' => $news,
            'banners' => $banners,
            'intro' => Setting::getValue('news_intro_html', ''),
        ]);
    }

    public function show(string $slug): View
    {
        $post = NewsPost::query()
            ->where('slug', $slug)
            ->where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('site.news.show', [
            'activeNav' => 'news',
            'title' => $post->title.' - العبادلة',
            'metaDescription' => $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags((string) $post->body), 160),
            'post' => $post,
        ]);
    }
}
