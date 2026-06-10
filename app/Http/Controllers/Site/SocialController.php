<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SocialCategory;
use App\Models\SocialOccasion;
use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialController extends Controller
{
    public function index(Request $request): View
    {
        $categories = SocialCategory::query()->orderBy('sort_order')->get();

        $categorySlug = trim((string) $request->query('category', ''));
        $categorySlug = $categorySlug === '' ? null : $categorySlug;

        $activeCategory = null;
        if ($categorySlug) {
            $activeCategory = $categories->firstWhere('slug', $categorySlug);
        }

        $occasions = SocialOccasion::query()
            ->with('category')
            ->where('published', true);

        if ($activeCategory) {
            $occasions->where('social_category_id', $activeCategory->id);
        }

        $occasions = $occasions
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $heroImage = Setting::getValue('social_banner_image', '');
        if ($heroImage === '') {
            $heroImageUrl = asset('legacy/img/banner.jpg');
        } elseif (preg_match('#^https?://#i', $heroImage)) {
            $heroImageUrl = $heroImage;
        } else {
            $heroImageUrl = Media::settingImage($heroImage, 'img/banner.jpg');
        }

        $heroTitle = Setting::getValue('social_hero_title', 'إجتماعيات العائلة');

        return view('site.social', [
            'activeNav' => 'social',
            'title' => Setting::getValue('social_meta_title', 'إجتماعيات - العبادلة'),
            'metaDescription' => Setting::getValue('social_meta_description', 'مناسبات عائلة العبادلة.'),
            'introHtml' => Setting::getValue('social_intro_html', ''),
            'categories' => $categories,
            'occasions' => $occasions,
            'activeCategorySlug' => $categorySlug,
            'heroImageUrl' => $heroImageUrl,
            'heroTitle' => $heroTitle,
        ]);
    }

    public function show(string $slug): View
    {
        $occasion = SocialOccasion::query()
            ->with('category')
            ->where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        $gallery = collect($occasion->images ?? [])
            ->filter()
            ->map(fn ($path) => Media::url($path))
            ->values()
            ->all();

        $latest = SocialOccasion::query()
            ->with('category')
            ->where('published', true)
            ->where('id', '!=', $occasion->id)
            ->latest()
            ->limit(6)
            ->get();

        return view('site.social.show', [
            'activeNav' => 'social',
            'title' => $occasion->title.' - العبادلة',
            'metaDescription' => $occasion->excerpt
                ?: \Illuminate\Support\Str::limit(strip_tags((string) $occasion->body), 160),
            'occasion' => $occasion,
            'gallery' => $gallery,
            'latest' => $latest,
        ]);
    }
}
