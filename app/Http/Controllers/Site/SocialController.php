<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SocialCategory;
use App\Models\SocialOccasion;
use Illuminate\View\View;

class SocialController extends Controller
{
    public function __invoke(): View
    {
        $categories = SocialCategory::query()->orderBy('sort_order')->get();

        $occasions = SocialOccasion::query()
            ->with('category')
            ->where('published', true)
            ->orderByDesc('occurred_on')
            ->paginate(24);

        return view('site.social', [
            'activeNav' => 'social',
            'title' => Setting::getValue('social_meta_title', 'إجتماعيات - العبادلة'),
            'metaDescription' => Setting::getValue('social_meta_description', 'مناسبات عائلة العبادلة.'),
            'introHtml' => Setting::getValue('social_intro_html', ''),
            'categories' => $categories,
            'occasions' => $occasions,
        ]);
    }
}
