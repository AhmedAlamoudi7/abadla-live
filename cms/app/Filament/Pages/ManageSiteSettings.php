<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-site-settings';

    protected static ?string $navigationGroup = 'إعدادات الموقع';

    protected static ?string $navigationLabel = 'إعدادات عامة';

    protected static ?string $title = 'إعدادات الموقع';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $keys = [
            'breaking_ticker',
            'copyright_line',
            'privacy_url',
            'terms_url',
            'social_facebook',
            'social_instagram',
            'social_youtube',
            'social_x',
            'social_telegram',
            'whatsapp_link',
            'whatsapp_text',
            'hero_date_line',
            'events_intro_1',
            'events_intro_2',
            'news_intro_html',
            'home_family_intro_title',
            'home_family_intro_html',
            'stat_female',
            'stat_male',
            'stat_alive',
            'stat_total',
            'stat_wide_one_label',
            'stat_wide_one_value',
            'stat_wide_two_label',
            'stat_wide_two_value',
            'media_articles_image',
            'media_video_url',
            'landmark_title',
            'landmark_body_html',
            'landmark_image',
            'landmark_more_url',
        ];

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = Setting::getValue($key, '');
        }

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('شريط الأخبار والواجهة')
                    ->schema([
                        Textarea::make('breaking_ticker')->label('نص الشريط (آخر الأخبار)')->rows(2),
                        TextInput::make('hero_date_line')->label('سطر التاريخ في الرئيسية')->maxLength(500),
                    ]),
                Section::make('التذييل والروابط القانونية')
                    ->schema([
                        TextInput::make('copyright_line')->label('سطر حقوق النشر')->maxLength(500),
                        TextInput::make('privacy_url')->label('رابط سياسة الخصوصية')->url()->maxLength(500)->nullable(),
                        TextInput::make('terms_url')->label('رابط الشروط والأحكام')->url()->maxLength(500)->nullable(),
                    ])
                    ->columns(1),
                Section::make('وسائل التواصل')
                    ->schema([
                        TextInput::make('social_facebook')->label('Facebook')->url()->maxLength(500)->nullable(),
                        TextInput::make('social_instagram')->label('Instagram')->url()->maxLength(500)->nullable(),
                        TextInput::make('social_youtube')->label('YouTube')->url()->maxLength(500)->nullable(),
                        TextInput::make('social_x')->label('X / Twitter')->url()->maxLength(500)->nullable(),
                        TextInput::make('social_telegram')->label('Telegram')->url()->maxLength(500)->nullable(),
                    ])
                    ->columns(2),
                Section::make('واتساب')
                    ->schema([
                        TextInput::make('whatsapp_link')->label('رابط المجموعة')->url()->maxLength(500)->nullable(),
                        Textarea::make('whatsapp_text')->label('نص دعوة الواتساب')->rows(2),
                    ]),
                Section::make('صفحة الأخبار')
                    ->schema([
                        Textarea::make('news_intro_html')->label('مقدمة صفحة الأخبار (HTML)')->rows(4),
                    ]),
                Section::make('صفحة الفعاليات (مقدمة)')
                    ->schema([
                        Textarea::make('events_intro_1')->label('المقدمة — الفقرة الأولى (يدعم HTML)')->rows(4),
                        Textarea::make('events_intro_2')->label('المقدمة — الفقرة الثانية (يدعم HTML)')->rows(4),
                    ]),
                Section::make('الرئيسية — قسم «تعرف على العائلة»')
                    ->schema([
                        TextInput::make('home_family_intro_title')->label('عنوان القسم')->maxLength(500),
                        Textarea::make('home_family_intro_html')->label('المحتوى (HTML)')->rows(6),
                    ]),
                Section::make('الرئيسية — معرض الوسائط')
                    ->schema([
                        TextInput::make('media_articles_image')->label('صورة قسم المقالات (مسار داخل legacy/ أو رابط كامل)')->maxLength(500),
                        TextInput::make('media_video_url')->label('رابط فيديو البرومو (YouTube أو ملف)')->url()->maxLength(1000)->nullable(),
                    ]),
                Section::make('الرئيسية — إحصائيات العائلة')
                    ->schema([
                        TextInput::make('stat_female')->label('إجمالي الإناث')->maxLength(50),
                        TextInput::make('stat_male')->label('إجمالي الذكور')->maxLength(50),
                        TextInput::make('stat_alive')->label('على قيد الحياة')->maxLength(50),
                        TextInput::make('stat_total')->label('إجمالي الأفراد')->maxLength(50),
                        TextInput::make('stat_wide_one_label')->label('بطاقة عريضة — تسمية 1')->maxLength(200),
                        TextInput::make('stat_wide_one_value')->label('بطاقة عريضة — قيمة 1')->maxLength(200),
                        TextInput::make('stat_wide_two_label')->label('بطاقة عريضة — تسمية 2')->maxLength(200),
                        TextInput::make('stat_wide_two_value')->label('بطاقة عريضة — قيمة 2')->maxLength(200),
                    ])
                    ->columns(2),
                Section::make('الرئيسية — مكتبة الصور (المعلم / المحتوى)')
                    ->schema([
                        TextInput::make('landmark_title')->label('عنوان القسم')->maxLength(300),
                        Textarea::make('landmark_body_html')->label('النص (HTML)')->rows(5),
                        TextInput::make('landmark_image')->label('صورة القسم (مسار داخل legacy/ أو رابط كامل)')->maxLength(500),
                        TextInput::make('landmark_more_url')->label('رابط «مشاهدة المزيد»')->url()->maxLength(500)->nullable(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        foreach ($state as $key => $value) {
            Setting::setValue((string) $key, $value === null || $value === '' ? null : (string) $value);
        }

        Notification::make()
            ->title('تم حفظ الإعدادات')
            ->success()
            ->send();
    }
}
