<?php

namespace Database\Seeders;

use App\Models\AlbumCategory;
use App\Models\AlbumItem;
use App\Models\ArchiveSubmission;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\FamilyBranch;
use App\Models\FamilyMember;
use App\Models\FamousMember;
use App\Models\GalleryImage;
use App\Models\HeroSlide;
use App\Models\HomeFeaturedEvent;
use App\Models\NewsBanner;
use App\Models\NewsPost;
use App\Models\NewsletterSubscriber;
use App\Models\Personality;
use App\Models\Setting;
use App\Models\SocialCategory;
use App\Models\SocialOccasion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AbadlaDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedSocialCategories();
        $this->seedFamilyBranches();
        $branches = FamilyBranch::query()->orderBy('sort_order')->get();

        $this->seedEvents();
        $this->seedHomeFeaturedEvents();

        $this->seedNewsPosts();
        $this->seedNewsBanners();

        $this->seedHeroSlides();

        $this->seedAlbumCategoriesAndItems();

        $this->seedGalleryImages();

        $this->seedSocialOccasions();

        $this->seedFamilyTree($branches->first());

        $this->seedPersonalities($branches->first());
        $this->seedFamousMembers();

        $this->seedNewsletterSubscribers();
        $this->seedArchiveSubmissions();
        $this->seedContactMessages();
    }

    private function seedSocialCategories(): void
    {
        $social = [
            ['name' => 'خطوبة', 'slug' => 'engagement', 'sort_order' => 1],
            ['name' => 'زواج', 'slug' => 'wedding', 'sort_order' => 2],
            ['name' => 'مواليد', 'slug' => 'birth', 'sort_order' => 3],
            ['name' => 'تخرج', 'slug' => 'graduation', 'sort_order' => 4],
            ['name' => 'سفر', 'slug' => 'travel', 'sort_order' => 5],
            ['name' => 'وفاة', 'slug' => 'death', 'sort_order' => 6],
            ['name' => 'شهداء', 'slug' => 'martyrs', 'sort_order' => 7],
        ];
        foreach ($social as $row) {
            SocialCategory::query()->updateOrCreate(['slug' => $row['slug']], $row);
        }
    }

    private function seedSettings(): void
    {
        Setting::setValue('breaking_ticker', 'خبر عاجل ومهم الآن يحدث في قطاع غزة … اغتنم الفرصة الآن …');
        Setting::setValue('copyright_line', 'جميع الحقوق محفوظة لعائلة العبادلة © '.date('Y'));
        Setting::setValue('about_title', 'عائلة العبادلة في الوطن والشتات');
        Setting::setValue('about_lead', 'فلسطين . قطاع غزة . خان يونس');
        Setting::setValue('about_body_html', '<p>تُعد عائلة العبادلة من العائلات العربية الكبيرة ذات الجذور الأصيلة. يُدار هذا النص بالكامل من لوحة التحكم أو من إعدادات الموقع.</p>');
        Setting::setValue('home_family_intro_html', '<p class="article-text">تُعد عائلة العبادلة واحدة من العائلات التي تركت بصمة واضحة في محيطها الاجتماعي عبر سنوات طويلة. تميّزت العائلة بروابطها المتينة بين أفرادها، حيث يشكّل التعاون، الاحترام، والتكافل أساس العلاقات داخلها.</p>');
        Setting::setValue('landmark_body_html', '<p>تُعد عائلة العبادلة واحدة من العائلات التي تركت بصمة واضحة في محيطها الاجتماعي عبر سنوات طويلة.</p>');
        Setting::setValue('news_intro_html', '<p style="text-align:center;">آخر الأخبار والتحديثات من أبناء العائلة في الوطن والشتات.</p>');
    }

    private function seedFamilyBranches(): void
    {
        $rows = [
            ['name' => 'فرع الكرامة', 'slug' => 'al-karama', 'sort_order' => 1, 'member_count' => 120],
            ['name' => 'فرع السلام', 'slug' => 'al-salam', 'sort_order' => 2, 'member_count' => 95],
            ['name' => 'فرع النور', 'slug' => 'al-nour', 'sort_order' => 3, 'member_count' => 80],
            ['name' => 'فرع الوفاء', 'slug' => 'al-wafa', 'sort_order' => 4, 'member_count' => 72],
            ['name' => 'فرع الأمل', 'slug' => 'al-amal', 'sort_order' => 5, 'member_count' => 64],
        ];
        foreach ($rows as $row) {
            FamilyBranch::query()->updateOrCreate(['slug' => $row['slug']], $row);
        }
    }

    private function seedEvents(): void
    {
        $items = [
            [
                'slug' => 'event-seed-reunion-2026',
                'title' => 'لقاء عائلي سنوي',
                'description' => 'تجمع سنوي لأبناء العائلة في خان يونس.',
                'starts_at' => Carbon::now()->addMonths(2)->setTime(17, 0),
                'ends_at' => Carbon::now()->addMonths(2)->setTime(21, 0),
                'location' => 'قاعة الأفراح — خان يونس',
                'body' => '<p>برنامج فقرات ترحيبية، عشاء جماعي، وجلسة تعارف بين الأجيال.</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'event-seed-charity-2026',
                'title' => 'يوم تطوعي خيري',
                'description' => 'مبادرة تطوعية لدعم الأسر المحتاجة.',
                'starts_at' => Carbon::now()->addMonth()->setTime(9, 0),
                'location' => 'مركز العائلة',
                'body' => '<p>توزيع طرود غذائية وتنظيم ورش للأطفال.</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'event-seed-heritage-day',
                'title' => 'يوم التراث العائلي',
                'description' => 'عرض صور ومقتنيات وقصص من تاريخ العائلة.',
                'starts_at' => Carbon::now()->addWeeks(6)->setTime(16, 0),
                'location' => 'دار العائلة',
                'body' => '<p>جلسات حكي مع كبار السن ومعرض صور أرشيفية.</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'event-seed-youth-forum',
                'title' => 'ملتقى شباب العائلة',
                'description' => 'لقاء حواري حول التعليم والعمل والمغتربين.',
                'starts_at' => Carbon::now()->addWeeks(3)->setTime(18, 30),
                'location' => 'أونلاين + حضوري',
                'body' => '<p>جلسات نقاش وورش مهارات رقمية.</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'event-seed-spring-walk',
                'title' => 'مشترك ربيعي للعائلة',
                'description' => 'نزهة جماعية في أحد المواقع المفتوحة.',
                'starts_at' => Carbon::now()->addWeeks(5)->setTime(8, 0),
                'location' => 'كورنيش البحر — موعد يُحدَّد لاحقاً',
                'body' => '<p>أنشطة للأطفال والعائلات، ووجبة إفطار جماعية.</p>',
                'is_published' => true,
            ],
        ];

        foreach ($items as $data) {
            Event::query()->updateOrCreate(
                ['slug' => $data['slug']],
                $data,
            );
        }
    }

    private function seedHomeFeaturedEvents(): void
    {
        HomeFeaturedEvent::query()->delete();

        $ids = Event::query()
            ->whereIn('slug', [
                'event-seed-reunion-2026',
                'event-seed-charity-2026',
                'event-seed-heritage-day',
            ])
            ->orderBy('id')
            ->pluck('id');

        foreach ($ids as $i => $eventId) {
            HomeFeaturedEvent::query()->create([
                'event_id' => $eventId,
                'sort_order' => $i + 1,
            ]);
        }
    }

    private function seedNewsPosts(): void
    {
        $posts = [
            [
                'slug' => 'news-seed-welcome-2026',
                'title' => 'تحديثات جديدة على موقع العائلة',
                'excerpt' => 'نعمل على تحسين تجربة التصفح وإضافة أقسام تفاعلية.',
                'body' => '<p>نرحب بأبناء العائلة في الوطن والشتات، ونأمل أن يكون الموقع منصة للتواصل والترابط.</p>',
                'published_at' => Carbon::now()->subDays(2),
                'published' => true,
                'show_on_home' => true,
                'category' => 'عام',
                'tags' => ['موقع', 'تحديث'],
            ],
            [
                'slug' => 'news-seed-education',
                'title' => 'تفوق أبناء العائلة في الجامعات',
                'excerpt' => 'تهنئة لعدد من الخريجين والمتفوقين هذا العام.',
                'body' => '<p>نتمنى لهم مزيداً من التوفيق في مسيرتهم العلمية والمهنية.</p>',
                'published_at' => Carbon::now()->subDays(5),
                'published' => true,
                'show_on_home' => true,
                'category' => 'تعليم',
                'tags' => ['تخرج', 'تفوق'],
            ],
            [
                'slug' => 'news-seed-health',
                'title' => 'مبادرة صحية مجتمعية',
                'excerpt' => 'تنظيم يوم للكشف المبكر بالتعاون مع أطباء من العائلة.',
                'body' => '<p>شكراً لكل من ساهم في نجاح الفعالية.</p>',
                'published_at' => Carbon::now()->subDays(8),
                'published' => true,
                'show_on_home' => true,
                'category' => 'صحة',
                'tags' => ['صحة', 'مبادرة'],
            ],
            [
                'slug' => 'news-seed-diaspora',
                'title' => 'لقاء افتراضي مع أبناء المغتربين',
                'excerpt' => 'جلسة عبر الإنترنت لمناقشة فرص التعاون والزيارات العائلية.',
                'body' => '<p>سُجّلت مداخلات من عدة دول، وتم الاتفاق على لقاءات دورية.</p>',
                'published_at' => Carbon::now()->subDays(12),
                'published' => true,
                'show_on_home' => false,
                'category' => 'مغتربون',
                'tags' => ['مغتربين', 'أونلاين'],
            ],
            [
                'slug' => 'news-seed-culture',
                'title' => 'حفل خطابي بمناسبة عيد الفطر',
                'excerpt' => 'كلمة ترحيبية وعشاء خفيف في أجواء عائلية.',
                'body' => '<p>دام الله الأفراح على العائلة أجمعين.</p>',
                'published_at' => Carbon::now()->subDays(20),
                'published' => true,
                'show_on_home' => false,
                'category' => 'مناسبات',
                'tags' => ['عيد', 'لقاء'],
            ],
        ];

        foreach ($posts as $row) {
            NewsPost::query()->updateOrCreate(
                ['slug' => $row['slug']],
                $row,
            );
        }
    }

    private function seedNewsBanners(): void
    {
        for ($slot = 1; $slot <= 5; $slot++) {
            NewsBanner::query()->updateOrCreate(
                ['slot' => $slot],
                [
                    'image' => null,
                    'caption' => 'شريط أخبار تجريبي — موضع '.$slot,
                    'link' => '/news',
                    'is_active' => $slot <= 3,
                ],
            );
        }
    }

    private function seedHeroSlides(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            HeroSlide::query()->updateOrCreate(
                ['sort_order' => $i],
                [
                    'image' => null,
                    'link' => $i === 1 ? '/' : null,
                    'published' => true,
                ],
            );
        }
    }

    private function seedAlbumCategoriesAndItems(): void
    {
        $categories = [
            ['name' => 'مناسبات عائلية', 'slug' => 'events', 'sort_order' => 1],
            ['name' => 'تراث', 'slug' => 'heritage', 'sort_order' => 2],
            ['name' => 'أماكن', 'slug' => 'places', 'sort_order' => 3],
            ['name' => 'مناسبات وطنية', 'slug' => 'national', 'sort_order' => 4],
            ['name' => 'ذكريات', 'slug' => 'memories', 'sort_order' => 5],
        ];

        foreach ($categories as $row) {
            AlbumCategory::query()->updateOrCreate(['slug' => $row['slug']], $row);
        }

        $cats = AlbumCategory::query()->orderBy('sort_order')->get();
        foreach ($cats as $cat) {
            for ($n = 1; $n <= 5; $n++) {
                $caption = 'صورة ألبوم — '.$cat->name.' — '.$n;
                AlbumItem::query()->updateOrCreate(
                    [
                        'album_category_id' => $cat->id,
                        'caption' => $caption,
                    ],
                    [
                        'image' => null,
                        'sort_order' => $n,
                        'published' => true,
                    ],
                );
            }
        }
    }

    private function seedGalleryImages(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            GalleryImage::query()->updateOrCreate(
                ['caption' => 'مكتبة الصور — بذرة '.$i],
                [
                    'image' => null,
                    'sort_order' => $i,
                    'published' => true,
                ],
            );
        }
    }

    private function seedSocialOccasions(): void
    {
        $socialCats = SocialCategory::query()->orderBy('sort_order')->get();
        if ($socialCats->isEmpty()) {
            return;
        }

        $titles = [
            'تهنئة بمناسبة الخطوبة',
            'أفراح زفاف في العائلة',
            'مولود جديد — بارك الله لكم',
            'حفل تخرج من الجامعة',
            'وفاة رحمها الله — تعازٍ للعائلة',
        ];

        foreach ($titles as $idx => $title) {
            $cat = $socialCats[$idx % $socialCats->count()];
            SocialOccasion::query()->updateOrCreate(
                [
                    'social_category_id' => $cat->id,
                    'title' => $title,
                ],
                [
                    'occurred_on' => Carbon::now()->subDays(10 + $idx * 3),
                    'excerpt' => 'وصف قصير لمناسبة اجتماعية — بذرة بيانات رقم '.($idx + 1).'.',
                    'published' => true,
                ],
            );
        }
    }

    private function seedFamilyTree(?FamilyBranch $branch): void
    {
        if (! $branch) {
            return;
        }

        $root = FamilyMember::query()->updateOrCreate(
            ['full_name' => 'بذرة الشجرة — الجد الأعلى'],
            [
                'parent_id' => null,
                'family_branch_id' => $branch->id,
                'short_name' => 'الجد الأعلى',
                'role' => 'الجذر',
                'year_range' => '1890 - 1975',
                'bio' => 'عُقدة أولى في بيانات العيِّنة للشجرة العائلية.',
                'sort_order' => 0,
                'icon_key' => 'fas fa-crown',
                'is_public' => true,
            ],
        );

        $children = [
            ['full_name' => 'بذرة الشجرة — الابن الأول', 'short_name' => 'الابن 1', 'year_range' => '1955 -', 'sort_order' => 1],
            ['full_name' => 'بذرة الشجرة — الابن الثاني', 'short_name' => 'الابن 2', 'year_range' => '1958 -', 'sort_order' => 2],
            ['full_name' => 'بذرة الشجرة — الابن الثالث', 'short_name' => 'الابن 3', 'year_range' => '1961 -', 'sort_order' => 3],
            ['full_name' => 'بذرة الشجرة — الابنة', 'short_name' => 'الابنة', 'year_range' => '1964 -', 'sort_order' => 4],
        ];

        foreach ($children as $row) {
            FamilyMember::query()->updateOrCreate(
                ['full_name' => $row['full_name']],
                [
                    'parent_id' => $root->id,
                    'family_branch_id' => $branch->id,
                    'short_name' => $row['short_name'],
                    'role' => 'فرع',
                    'year_range' => $row['year_range'],
                    'bio' => 'فرع تجريبي ضمن بذرة بيانات الشجرة.',
                    'sort_order' => $row['sort_order'],
                    'icon_key' => 'fas fa-user',
                    'is_public' => true,
                ],
            );
        }
    }

    private function seedPersonalities(?FamilyBranch $branch): void
    {
        if (! $branch) {
            return;
        }

        $names = [
            'الشخصية الاعتبارية — أحمد',
            'الشخصية الاعتبارية — فاطمة',
            'الشخصية الاعتبارية — خالد',
            'الشخصية الاعتبارية — سعيد',
            'الشخصية الاعتبارية — ليلى',
        ];

        foreach ($names as $i => $name) {
            Personality::query()->updateOrCreate(
                ['full_name' => $name],
                [
                    'family_branch_id' => $branch->id,
                    'birth_gregorian' => (1950 + $i).'-01-15',
                    'birth_hijri' => 'تقريبي',
                    'location' => 'فلسطين',
                    'sort_order' => $i + 1,
                    'published' => true,
                ],
            );
        }
    }

    private function seedFamousMembers(): void
    {
        $rows = [
            ['name' => 'رمز عائلي — الأول', 'line_one' => 'إنجاز مجتمعي', 'line_two' => 'تكريم من الجهات المحلية'],
            ['name' => 'رمز عائلي — الثاني', 'line_one' => 'مسيرة علمية', 'line_two' => 'دكتوراه في الهندسة'],
            ['name' => 'رمز عائلي — الثالث', 'line_one' => 'ريادة أعمال', 'line_two' => 'مشاريع خيرية'],
            ['name' => 'رمز عائلي — الرابع', 'line_one' => 'ثقافة وفن', 'line_two' => 'مؤلف ومبدع'],
            ['name' => 'رمز عائلي — الخامس', 'line_one' => 'رياضة ومجتمع', 'line_two' => 'مدرب شباب'],
        ];

        foreach ($rows as $i => $row) {
            FamousMember::query()->updateOrCreate(
                ['name' => $row['name']],
                [
                    'line_one' => $row['line_one'],
                    'line_two' => $row['line_two'],
                    'sort_order' => $i + 1,
                ],
            );
        }
    }

    private function seedNewsletterSubscribers(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            NewsletterSubscriber::query()->updateOrCreate(
                ['email' => 'subscriber'.$i.'@example.invalid'],
                ['subscribed_at' => Carbon::now()->subDays($i)],
            );
        }
    }

    private function seedArchiveSubmissions(): void
    {
        $types = ['أفراد', 'عائلة', 'مغترب', 'أخرى', 'أفراد'];
        foreach ($types as $i => $type) {
            ArchiveSubmission::query()->updateOrCreate(
                [
                    'full_name' => 'طلب أرشيف بذرة — '.($i + 1),
                    'email' => 'archive'.($i + 1).'@example.invalid',
                ],
                [
                    'type' => $type,
                    'phone_country' => '+970',
                    'phone_number' => '59900000'.$i,
                    'status' => 'pending',
                ],
            );
        }
    }

    private function seedContactMessages(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $msg = 'رسالة تواصل تجريبية رقم '.$i.' — نص موحّد لاختبار لوحة الرسائل.';
            ContactMessage::query()->firstOrCreate(
                ['message' => $msg],
                [
                    'name' => 'زائر تجريبي '.$i,
                    'phone' => '059900000'.$i,
                ],
            );
        }
    }
}
