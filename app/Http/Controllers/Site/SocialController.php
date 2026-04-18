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
    public function __invoke(Request $request): View
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
            ->orderByDesc('occurred_on')
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
}
