<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
            'media_video_url',
            'landmark_title',
            'landmark_body_html',
            'landmark_more_url',
        ];

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = Setting::getValue($key, '');
        }

        $landmark = (string) Setting::getValue('landmark_image', '');
        $data['landmark_image_file'] = self::isStoredHomeSectionPath($landmark) ? $landmark : null;
        $data['landmark_image_path'] = self::isStoredHomeSectionPath($landmark) ? '' : $landmark;

        $mediaArticles = (string) Setting::getValue('media_articles_image', '');
        $data['media_articles_image_file'] = self::isStoredHomeSectionPath($mediaArticles) ? $mediaArticles : null;
        $data['media_articles_image_path'] = self::isStoredHomeSectionPath($mediaArticles) ? '' : $mediaArticles;

        $this->form->fill($data);
    }

    private static function isStoredHomeSectionPath(string $path): bool
    {
        $path = ltrim($path, '/');

        return $path !== '' && str_starts_with($path, 'home-sections/');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('شريط الأخبار والواجهة')
                    ->schema([
                        Textarea::make('breaking_ticker')->label('نص الشريط (آخر الأخبار)')->rows(2),
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
                        TextInput::make('whatsapp_link')->label('رابط المجموعة / واتساب')->url()->maxLength(500)->nullable(),
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
                        FileUpload::make('media_articles_image_file')
                            ->label('صورة قسم المقالات (رفع ملف)')
                            ->image()
                            ->disk('public')
                            ->directory('home-sections')
                            ->visibility('public')
                            ->nullable(),
                        TextInput::make('media_articles_image_path')
                            ->label('أو مسار داخل legacy/ أو رابط كامل (بدون رفع)')
                            ->maxLength(1000)
                            ->placeholder('مثال: img/article.jpg أو https://…'),
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
                        FileUpload::make('landmark_image_file')
                            ->label('صورة القسم (رفع ملف)')
                            ->image()
                            ->disk('public')
                            ->directory('home-sections')
                            ->visibility('public')
                            ->nullable(),
                        TextInput::make('landmark_image_path')
                            ->label('أو مسار داخل legacy/ أو رابط كامل (بدون رفع)')
                            ->maxLength(1000)
                            ->placeholder('مثال: img/jureselem.png أو https://…'),
                        TextInput::make('landmark_more_url')->label('رابط «مشاهدة المزيد»')->url()->maxLength(500)->nullable(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $landmark = $this->resolveHomeSectionImage(
            $state['landmark_image_file'] ?? null,
            (string) ($state['landmark_image_path'] ?? '')
        );
        $mediaArticles = $this->resolveHomeSectionImage(
            $state['media_articles_image_file'] ?? null,
            (string) ($state['media_articles_image_path'] ?? '')
        );

        unset(
            $state['landmark_image_file'],
            $state['landmark_image_path'],
            $state['media_articles_image_file'],
            $state['media_articles_image_path'],
        );

        $state['landmark_image'] = $landmark;
        $state['media_articles_image'] = $mediaArticles;

        foreach ($state as $key => $value) {
            Setting::setValue((string) $key, $value === null || $value === '' ? null : (string) $value);
        }

        Notification::make()
            ->title('تم حفظ الإعدادات')
            ->success()
            ->send();
    }

    private function resolveHomeSectionImage(mixed $file, string $path): ?string
    {
        if (is_array($file)) {
            $file = $file[0] ?? null;
        }

        if ($file instanceof TemporaryUploadedFile) {
            return $file->store('home-sections', 'public');
        }

        if (is_string($file) && $file !== '') {
            return $file;
        }

        $path = trim($path);

        return $path === '' ? null : $path;
    }
}
