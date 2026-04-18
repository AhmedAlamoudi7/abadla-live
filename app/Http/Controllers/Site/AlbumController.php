<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AlbumCategory;
use App\Models\AlbumItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function __invoke(Request $request): View
    {
        $categories = AlbumCategory::query()->orderBy('sort_order')->get();

        $categorySlug = $request->query('category');

        $items = AlbumItem::query()
            ->with('category')
            ->where('published', true);

        if ($categorySlug) {
            $items->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        $items = $items
            ->orderBy('sort_order')
            ->paginate(24)
            ->withQueryString();

        return view('site.album', [
            'activeNav' => 'album',
            'title' => Setting::getValue('album_meta_title', 'الألبوم - العبادلة'),
            'metaDescription' => Setting::getValue('album_meta_description', 'ألبوم صور عائلة العبادلة.'),
            'introHtml' => Setting::getValue('album_intro_html', ''),
            'categories' => $categories,
            'items' => $items,
            'activeCategorySlug' => $categorySlug,
        ]);
    }
}
