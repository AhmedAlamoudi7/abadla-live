<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GalleryImage;
use App\Models\HeroSlide;
use App\Models\HomeFeaturedEvent;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $slides = HeroSlide::query()
            ->where('published', true)
            ->orderBy('sort_order')
            ->get();

        $featuredLinks = HomeFeaturedEvent::query()
            ->with('event')
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($row) => $row->event)
            ->filter()
            ->values();

        if ($featuredLinks->isEmpty()) {
            $featuredLinks = Event::query()
                ->where('is_published', true)
                ->orderByDesc('starts_at')
                ->limit(3)
                ->get();
        }

        $activityEvents = Event::query()
            ->where('is_published', true)
            ->orderByDesc('starts_at')
            ->limit(6)
            ->get();

        $galleryImages = GalleryImage::query()
            ->where('published', true)
            ->orderBy('sort_order')
            ->get();

        return view('site.home', [
            'activeNav' => 'home',
            'title' => Setting::getValue('meta_home_title', 'العبادلة - موقع العائلة'),
            'metaDescription' => Setting::getValue('meta_home_description', 'موقع عائلة العبادلة — أخبار، فعاليات، وتراث.'),
            'heroSlides' => $slides,
            'featuredEvents' => $featuredLinks,
            'activityEvents' => $activityEvents,
            'galleryImages' => $galleryImages,
            'familyIntroTitle' => Setting::getValue('home_family_intro_title', 'تعمـــــــــــــــق وتعرف على أصول العائلة ...'),
            'familyIntroHtml' => Setting::getValue('home_family_intro_html', ''),
            'statFemale' => Setting::getValue('stat_female', '54800'),
            'statMale' => Setting::getValue('stat_male', '66200'),
            'statAlive' => Setting::getValue('stat_alive', '12230'),
            'statTotal' => Setting::getValue('stat_total', '16500'),
            'statWideOneLabel' => Setting::getValue('stat_wide_one_label', 'أكبر فرع'),
            'statWideOneValue' => Setting::getValue('stat_wide_one_value', '—'),
            'statWideTwoLabel' => Setting::getValue('stat_wide_two_label', 'أكبر فرع'),
            'statWideTwoValue' => Setting::getValue('stat_wide_two_value', '—'),
            'landmarkTitle' => Setting::getValue('landmark_title', 'معالم تاريخية'),
            'landmarkBodyHtml' => Setting::getValue('landmark_body_html', ''),
            'landmarkImage' => Setting::getValue('landmark_image', 'img/jureselem.png'),
            'landmarkMoreUrl' => Setting::getValue('landmark_more_url', '#'),
            'mediaArticlesImage' => Setting::getValue('media_articles_image', 'img/article.jpg'),
            'mediaVideoUrl' => Setting::getValue('media_video_url', ''),
            'heroDateLine' => 'اليوم : '.now()->locale('ar')->isoFormat('dddd').' | التاريخ : '.now()->format('d/m/Y').' مـ',
        ]);
    }
}
