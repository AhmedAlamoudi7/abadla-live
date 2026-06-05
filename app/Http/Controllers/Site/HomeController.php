<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GalleryImage;
use App\Models\HeroSlide;
use App\Models\HomeFeaturedEvent;
use App\Models\NewsPost;
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

        // Activities row ("تصفح الفعاليات"): the latest 3 events the admin added (newest first).
        $activityEvents = Event::query()
            ->where('is_published', true)
            ->latest()
            ->limit(3)
            ->get();

        $galleryImages = GalleryImage::query()
            ->where('published', true)
            ->orderBy('sort_order')
            ->get();

        $publishedNews = fn () => NewsPost::query()
            ->where('type', NewsPost::TYPE_NEWS)
            ->where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        // Honor the "يظهر في الرئيسية" toggle; fall back to latest news when
        // the admin hasn't explicitly flagged any post (same pattern as featured events).
        $latestNews = $publishedNews()
            ->where('show_on_home', true)
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        if ($latestNews->isEmpty()) {
            $latestNews = $publishedNews()
                ->orderByDesc('published_at')
                ->limit(4)
                ->get();
        }

        $archiveTypes = collect(explode(',', (string) Setting::getValue('home_archive_types', 'أفراد,عائلة,مغترب,أخرى')))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values();

        if ($archiveTypes->isEmpty()) {
            $archiveTypes = collect(['أفراد', 'عائلة', 'مغترب', 'أخرى']);
        }

        return view('site.home', [
            'activeNav' => 'home',
            'title' => Setting::getValue('meta_home_title', 'العبادلة - موقع العائلة'),
            'metaDescription' => Setting::getValue('meta_home_description', 'موقع عائلة العبادلة — أخبار، فعاليات، وتراث.'),
            'heroSlides' => $slides,
            'featuredEvents' => $featuredLinks,
            'activityEvents' => $activityEvents,
            'galleryImages' => $galleryImages,
            'latestNews' => $latestNews,
            'archiveTypes' => $archiveTypes,
            'familyIntroTitle' => Setting::getValue('home_family_intro_title', 'تعمـــــــــــــــق وتعرف على أصول العائلة ...'),
            'familyIntroHtml' => Setting::getValue('home_family_intro_html', ''),
            'activitiesTitle' => Setting::getValue('home_activities_title', 'تصفح الفعاليات'),
            'statsTitle' => Setting::getValue('home_stats_title', 'إحصائيات العائلة'),
            'newsTitle' => Setting::getValue('home_news_title', 'آخر الأخبار'),
            'videoLabel' => Setting::getValue('home_video_label', 'برومو ومقاطع فيديو'),
            'archiveTitle' => Setting::getValue('home_archive_title', 'أضف بياناتك'),
            'archiveHelp' => Setting::getValue('home_archive_help', "يرجى تعبئة جميع البيانات صحيحة ومحدثة\nلإضافتها لأرشيف العائلة"),
            'statFemale' => Setting::getValue('stat_female', '54800'),
            'statMale' => Setting::getValue('stat_male', '66200'),
            'statAlive' => Setting::getValue('stat_alive', '12230'),
            'statTotal' => Setting::getValue('stat_total', '16500'),
            'statFemaleLabel' => Setting::getValue('stat_female_label', 'إجمالي الإناث'),
            'statMaleLabel' => Setting::getValue('stat_male_label', 'إجمالي الذكور'),
            'statAliveLabel' => Setting::getValue('stat_alive_label', 'على قيد الحياة'),
            'statTotalLabel' => Setting::getValue('stat_total_label', 'إجمالي عدد الأفراد'),
            'statWideOneLabel' => Setting::getValue('stat_wide_one_label', 'أكبر فرع'),
            'statWideOneValue' => Setting::getValue('stat_wide_one_value', '—'),
            'statWideTwoLabel' => Setting::getValue('stat_wide_two_label', 'أكبر فرع'),
            'statWideTwoValue' => Setting::getValue('stat_wide_two_value', '—'),
            'landmarkTitle' => Setting::getValue('landmark_title', 'معالم تاريخية'),
            'landmarkBodyHtml' => Setting::getValue('landmark_body_html', ''),
            'landmarkImage' => Setting::getValue('landmark_image', 'img/jureselem.png'),
            'landmarkMoreUrl' => Setting::getValue('landmark_more_url', '#'),
            'mediaArticlesImage' => Setting::getValue('media_articles_image', 'img/article.jpg'),
            'mediaArticlesLabel' => Setting::getValue('home_articles_label', 'مقالات'),
            'mediaVideoUrl' => Setting::getValue('media_video_url', ''),
            'heroDateLine' => 'اليوم : '.now()->locale('ar')->isoFormat('dddd').' | التاريخ : '.now()->format('d/m/Y').' مـ',
        ]);
    }
}
