<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\NewsBanner;
use App\Models\NewsPost;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $page = max(1, (int) $request->query('page', 1));

        $base = NewsPost::query()
            ->where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at');

        $banners = NewsBanner::query()->where('is_active', true)->orderBy('slot')->limit(2)->get();

        $idsUsed = collect();

        $hourlyPost = (clone $base)->where('is_hourly_featured', true)->orderByDesc('published_at')->first();
        if ($hourlyPost) {
            $idsUsed->push($hourlyPost->id);
        }

        $importantQ = (clone $base)->where('important_sort', '>', 0);
        if ($hourlyPost) {
            $importantQ->where('id', '!=', $hourlyPost->id);
        }
        $importantPosts = $importantQ
            ->orderByDesc('important_sort')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();
        $idsUsed = $idsUsed->merge($importantPosts->pluck('id'));

        $mosaicPool = (clone $base)
            ->whereNotIn('id', $idsUsed->unique()->filter()->all())
            ->orderByDesc('published_at')
            ->limit(12)
            ->get();

        /** @var Collection<int, NewsPost> $take */
        $take = $this->pickMosaicFour($mosaicPool);
        $mosaicHero = $take->get(0);
        $mosaicMid = $take->get(1);
        $mosaicSm1 = $take->get(2);
        $mosaicSm2 = $take->get(3);

        foreach ([$mosaicHero, $mosaicMid, $mosaicSm1, $mosaicSm2] as $p) {
            if ($p) {
                $idsUsed->push($p->id);
            }
        }

        $idsUsed = $idsUsed->unique()->filter()->values();

        $gridQuery = (clone $base)->whereNotIn('id', $idsUsed->all());

        $news = $gridQuery->paginate(8)->withQueryString();

        return view('site.news.index', [
            'activeNav' => 'news',
            'title' => Setting::getValue('news_meta_title', 'أخبار العائلة - العبادلة'),
            'metaDescription' => Setting::getValue('news_meta_description', 'آخر أخبار عائلة العبادلة.'),
            'news' => $news,
            'banners' => $banners,
            'hourlyPost' => $hourlyPost,
            'importantPosts' => $importantPosts,
            'mosaicHero' => $mosaicHero,
            'mosaicMid' => $mosaicMid,
            'mosaicSm1' => $mosaicSm1,
            'mosaicSm2' => $mosaicSm2,
            'showFullLayout' => $page === 1,
        ]);
    }

    /**
     * Prefer explicit layout_role; otherwise first four distinct posts.
     *
     * @param  Collection<int, NewsPost>  $pool
     * @return Collection<int, NewsPost|null>
     */
    private function pickMosaicFour(Collection $pool): Collection
    {
        if ($pool->isEmpty()) {
            return collect([null, null, null, null]);
        }

        $hero = $pool->first(fn (NewsPost $p) => $p->layout_role === 'hero') ?? $pool->first();
        $rest = $pool->filter(fn (NewsPost $p) => $p->id !== $hero->id)->values();

        $mid = $rest->first(fn (NewsPost $p) => $p->layout_role === 'mid') ?? $rest->get(0);
        $rest2 = $rest->filter(fn (NewsPost $p) => ! $mid || $p->id !== $mid->id)->values();

        $smTagged = $rest2->filter(fn (NewsPost $p) => $p->layout_role === 'sm')->values();
        $sm1 = $smTagged->get(0) ?? $rest2->get(0);
        $rest3 = $rest2->filter(fn (NewsPost $p) => ! $sm1 || $p->id !== $sm1->id)->values();
        $sm2 = $smTagged->get(1) ?? $rest3->get(0);

        return collect([$hero, $mid, $sm1, $sm2]);
    }

    public function show(string $slug): View
    {
        $post = NewsPost::query()
            ->where('slug', $slug)
            ->where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $latest = NewsPost::query()
            ->where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        return view('site.news.show', [
            'activeNav' => 'news',
            'title' => $post->title.' - العبادلة',
            'metaDescription' => $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags((string) $post->body), 160),
            'post' => $post,
            'latest' => $latest,
        ]);
    }
}
