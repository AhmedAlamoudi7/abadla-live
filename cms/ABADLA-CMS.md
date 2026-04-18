# عائلة العبادلة — Laravel + Filament لوحة التحكم

تم إعداد مشروع Laravel 11 داخل المجلد `cms/` مع **Filament 3** ولوحة عربية (`locale('ar')`) ومجموعات تنقل عربية حسب `MASTER_PROMPT_LARAVEL_FILAMENT.md`.

## المتطلبات

- PHP 8.2+
- Composer
- SQLite (افتراضي Laravel) أو MySQL

## التثبيت

```bash
cd cms
copy .env.example .env   # أو: cp .env.example .env
composer install
php artisan key:generate
php artisan filament:assets
```

### ويندوز: XAMPP يعرض PHP 8.0 و Composer يفشل

إذا كان `php -v` يظهر **8.0** رغم تثبيت PHP 8.3 عبر WinGet، فـ `C:\xampp\php` غالباً **أول** مسار في `PATH`. إما اضبط ترتيب المسارات في إعدادات Windows، أو شغّل Composer عبر السكربت التالي من مجلد `cms`:

```powershell
cd C:\Users\Ahmed\OneDrive\Desktop\abadla-new-modern22\cms
powershell -ExecutionPolicy Bypass -File .\Composer-WithPHP83.ps1 install
```

بعدها استخدم نفس الأسلوب لأوامر `composer` الأخرى، أو صحّح `PATH` ليستخدم PHP 8.3 افتراضياً.

### خطأ Composer: openssl extension is required

تثبيت WinGet لـ PHP غالباً يأتي بدون `php.ini` أو معطّل فيه `openssl`. شغّل **مرة واحدة** من مجلد `cms`:

```powershell
powershell -ExecutionPolicy Bypass -File .\Enable-PhpOpenSSL.ps1
```

ثم أعد:

```powershell
powershell -ExecutionPolicy Bypass -File .\Composer-WithPHP83.ps1 install
```

**يدوياً:** انسخ `php.ini-development` إلى `php.ini` بجانب `php.exe`، ثم في `php.ini` فعّل السطر `extension=openssl` (احذف الفاصلة المنقوطة من البداية) وتأكد أن `extension_dir` يشير لمجلد `ext`.

### خطأ: bootstrap/cache directory must be present and writable

غالباً المجلد **مُعلَّم للقراءة فقط** (يحدث مع نسخ من أرشيف أو OneDrive). من مجلد `cms`:

```powershell
powershell -ExecutionPolicy Bypass -File .\Fix-LaravelWritable.ps1
php artisan package:discover
```

أو يدوياً: خصائص المجلد `bootstrap\cache` وإلغاء **Read-only**، ثم إعادة `composer install` أو `php artisan package:discover`.

تأكد من قاعدة البيانات في `.env` (مثلاً `DB_CONNECTION=sqlite` وملف `database/database.sqlite` موجود).

```bash
php artisan filament:assets
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

إذا ظهرت صفحة `/admin/login` بدون تنسيق (404 لـ `forms.css` و`app.js` وغيرها)، نفّذ **`php artisan filament:assets`** — ينسخ ملفات Filament إلى `public/`. بعد `composer install` يُفضّل تشغيله مرة (أو أعد `composer install` بعد تحديث `composer.json` ليشغّل `post-install-cmd` تلقائياً).

## الدخول للوحة

- الرابط: `http://127.0.0.1:8000/admin`
- البريد: `admin@abadla.local`
- كلمة المرور: `password`

غيّر كلمة المرور فوراً في الإنتاج.

## الموقع العام (Blade)

- الصفحة الرئيسية والصفحات العامة: نفس عنوان التطبيق (مثلاً `http://127.0.0.1:8000/` عند استخدام `php artisan serve`).
- لوحة Filament: `http://127.0.0.1:8000/admin`
- الأصول الثابتة للواجهة مُنسوخة تحت `public/legacy/` (`style.css`، `script.js`، `tree.css`، `tree-app.js`، و`img/`).
- بعد رفع الصور من لوحة التحكم نفّذ `php artisan storage:link` لعرض الملفات من `storage/app/public`.

## ما يتضمنه المشروع

- **إعدادات الموقع** (`إعدادات عامة`): شريط الأخبار، التذييل، وسائل التواصل، واتساب، مقدمة صفحة الفعاليات — تُحفظ في جدول `settings`.
- **موارد Filament** لإدارة: الأخبار، الفعاليات، بانرات الأخبار، الفعاليات المميزة في الرئيسية، سلايدر الرئيسية، معرض الصور، فروع العائلة، أفراد الشجرة، الشخصيات، المشاهير، تصنيفات وصور الألبوم، تصنيفات ومناسبات الإجتماعيات، المقتنيات، طلبات الأرشيف، رسائل التواصل، المشتركين في النشرة.
- **API شجرة العائلة**: `GET /api/tree` — JSON هرمي لأفراد `family_members` الظاهرين للعامة (`is_public`).

## بعد التثبيت (Filament)

```bash
php artisan filament:upgrade
```

## الملاحظات

- رفع الصور يستخدم القرص `public` والمجلدات تحت `storage/app/public` — يشترط `storage:link`.
- الواجهة العامة للموقع الثابت ما زالت في المجلد الأب (`index.html` …). ربط Blade بالبيانات خطوة تالية حسب الـ master prompt.
