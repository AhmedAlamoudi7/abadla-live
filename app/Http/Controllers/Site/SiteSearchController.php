<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\FamilyMember;
use App\Models\NewsPost;
use App\Models\Personality;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $q = mb_substr($q, 0, 200);

        $results = [
            'news' => collect(),
            'events' => collect(),
            'personalities' => collect(),
            'members' => collect(),
        ];

        if ($q !== '') {
            $like = '%'.$q.'%';

            $results['news'] = NewsPost::query()
                ->where('published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('excerpt', 'like', $like);
                })
                ->orderByDesc('published_at')
                ->limit(20)
                ->get();

            $results['events'] = Event::query()
                ->where('is_published', true)
                ->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('description', 'like', $like);
                })
                ->orderByDesc('starts_at')
                ->limit(20)
                ->get();

            $results['personalities'] = Personality::query()
                ->where('published', true)
                ->where('full_name', 'like', $like)
                ->orderBy('sort_order')
                ->limit(20)
                ->get();

            $results['members'] = FamilyMember::query()
                ->where('is_public', true)
                ->where(function ($query) use ($like) {
                    $query->where('full_name', 'like', $like)
                        ->orWhere('short_name', 'like', $like)
                        ->orWhere('role', 'like', $like);
                })
                ->orderBy('sort_order')
                ->limit(20)
                ->get();
        }

        return view('site.search', [
            'activeNav' => '',
            'title' => Setting::getValue('search_meta_title', 'بحث - العبادلة'),
            'metaDescription' => Setting::getValue('search_meta_description', 'نتائج البحث في موقع العبادلة.'),
            'query' => $q,
            'results' => $results,
        ]);
    }
}
