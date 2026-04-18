<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SiteComposer
{
    public function compose(View $view): void
    {
        $view->with('site', [
            'breaking_ticker' => Setting::getValue('breaking_ticker', ''),
            'copyright_line' => Setting::getValue('copyright_line', ''),
            'footer_legal' => Setting::getValue('footer_legal', 'سياسة الخصوصية | الشروط والأحكام'),
            'whatsapp_line1' => Setting::getValue('whatsapp_line1', 'للانضمام في'),
            'whatsapp_line2' => Setting::getValue('whatsapp_line2', 'مجموعة واتساب'),
            'whatsapp_url' => Setting::getValue('whatsapp_url')
                ?: Setting::getValue('whatsapp_link', 'https://wa.me/972599626660'),
            'social_facebook' => Setting::getValue('social_facebook', '#'),
            'social_instagram' => Setting::getValue('social_instagram', '#'),
            'social_youtube' => Setting::getValue('social_youtube', '#'),
            'social_x' => Setting::getValue('social_x', '#'),
            'social_telegram' => Setting::getValue('social_telegram', '#'),
            'newsletter_title' => Setting::getValue('newsletter_title', 'للاشتراك في النشرة البريدية'),
            'newsletter_subtitle' => Setting::getValue('newsletter_subtitle', 'ابقَ على اطلاع بأحدث الأخبار والتحديثات من خلال نشرتنا الإخبارية'),
        ]);

        $view->with('siteSearchPages', [
            ['title' => 'الرئيسية', 'url' => route('home'), 'icon' => 'fas fa-home', 'keywords' => 'الصفحة الرئيسية أخبار فعاليات إحصائيات صور مكتبة نشرة العبادلة'],
            ['title' => 'عن العائلة', 'url' => route('about'), 'icon' => 'fas fa-users', 'keywords' => 'تاريخ العائلة القيم الرؤية الرسالة النشأة الجذور العبادلة عن'],
            ['title' => 'أخبار العائلة', 'url' => route('news.index'), 'icon' => 'fas fa-newspaper', 'keywords' => 'أخبار مقالات أحداث جديد آخر الأخبار تقارير'],
            ['title' => 'إجتماعيات', 'url' => route('social'), 'icon' => 'fas fa-heart', 'keywords' => 'زواج تهنئة عزاء مناسبات اجتماعيات تهاني أفراح'],
            ['title' => 'شجرة العائلة', 'url' => route('family-tree'), 'icon' => 'fas fa-sitemap', 'keywords' => 'شجرة نسب فروع أجداد الجد المؤسس'],
            ['title' => 'فعاليات', 'url' => route('events.index'), 'icon' => 'fas fa-calendar-check', 'keywords' => 'فعاليات أنشطة مناسبات ملتقى حفل تجمع لقاء عائلي'],
            ['title' => 'شخصيات إعتبارية', 'url' => route('personalities'), 'icon' => 'fas fa-user-tie', 'keywords' => 'شخصيات إعتبارية أعيان وجهاء شخصية بارزة كبار'],
            ['title' => 'الألبوم', 'url' => route('album'), 'icon' => 'fas fa-images', 'keywords' => 'ألبوم صور مكتبة لقطات ذكريات تاريخ مناسبات صورة'],
        ]);
    }
}
