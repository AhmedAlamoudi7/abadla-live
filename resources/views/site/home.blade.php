@extends('layouts.site')

@php
    use App\Support\Media;
    $galleryUrls = $galleryImages->isNotEmpty()
        ? $galleryImages->map(fn ($g) => Media::url($g->image))->values()->all()
        : [
            asset('legacy/img/library-image.png'),
            asset('legacy/img/library-image.png'),
            asset('legacy/img/library-image.png'),
        ];
@endphp

@section('content')
    <section class="hero container" data-animate="fade-up">
        <div class="hero-image hero-slider">
            <span class="date">{{ $heroDateLine }}</span>
            @php
                $slides = $heroSlides->isNotEmpty()
                    ? $heroSlides
                    : collect([null, null, null]);
                $fallbackBanners = ['legacy/img/banner.jpg', 'legacy/img/banner2.jpg', 'legacy/img/banner3.jpg'];
            @endphp
            @foreach ($slides as $i => $slide)
                @php
                    $src = $slide && ($slide->image ?? null)
                        ? Media::url($slide->image, asset($fallbackBanners[$i % 3]))
                        : asset($fallbackBanners[$i % 3]);
                @endphp
                <img src="{{ $src }}" class="slide {{ $i === 0 ? 'active' : '' }}" loading="lazy" alt="" />
            @endforeach
            <div class="slider-dots"></div>
        </div>
    </section>

    <section class="family-events">
        <div class="container">
            <div class="events-row" data-animate="fade-up">
                @foreach ($featuredEvents->take(3) as $i => $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="event-card {{ $i === 0 ? 'active' : '' }}">
                        <span class="event-date">
                            @if ($event->starts_at)
                                {{ $event->starts_at->locale('ar')->translatedFormat('j F Y') }}
                            @endif
                        </span>
                        <h3>{{ $event->title }}</h3>
                        <p>{{ $event->location }}</p>
                        @if ($event->cover_image)
                            <img src="{{ Media::url($event->cover_image) }}" alt="" />
                        @else
                            <img src="{{ asset('legacy/img/event'.($i % 3 + 1).'.jpg') }}" alt="" />
                        @endif
                        <span class="event-btn">مشاهدة المزيد <img src="{{ asset('legacy/img/arrow-left.svg') }}" class="btn-icon" alt="" /></span>
                    </a>
                    @if ($i === 0)
                        <button class="arrow right" type="button" aria-label="التالي">›</button>
                    @endif
                    @if ($i === 1)
                        <button class="arrow left" type="button" aria-label="السابق">‹</button>
                    @endif
                @endforeach
            </div>

            <section class="family-desc section-home-motion" data-animate="fade-up">
                <div class="container family-desc-inner">
                    <div class="family-title" data-animate="fade-right">
                        <h2>{{ $familyIntroTitle }}</h2>
                    </div>
                    <div class="family-text" data-animate="fade-left">
                        @if ($familyIntroHtml)
                            <div class="article-text">{!! $familyIntroHtml !!}</div>
                        @else
                            <p class="article-text">يُدار هذا النص من لوحة التحكم — أضف مقدمة عن العائلة من إعدادات الموقع أو من لوحة Filament.</p>
                        @endif
                    </div>
                </div>
            </section>

            <section class="media-showcase section-home-motion" data-animate="fade-up">
                <div class="container">
                    <div class="media-wrapper">
                        <a href="{{ route('articles.index') }}" class="media-block articles" aria-label="{{ $mediaArticlesLabel }}">
                            <div class="media-head"><h3>{{ $mediaArticlesLabel }}</h3></div>
                            <div class="articles-image">
                                <img src="{{ Media::settingImage($mediaArticlesImage ?? null, 'img/article.jpg') }}" alt="{{ $mediaArticlesLabel }}" />
                            </div>
                        </a>
                        <div class="media-block video">
                            <div class="media-head"><h3>برومو ومقاطع فيديو</h3></div>
                            <div class="video-box" data-video-url="{{ e($mediaVideoUrl) }}"><span class="play-btn">▶</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-title" data-animate="fade-up">
                <div class="title-wrapper">
                    <span class="line"></span>
                    <h2 class="gradient-text">تصفح الفعاليات</h2>
                    <span class="line"></span>
                </div>
            </section>

            <div class="activites-row" data-animate="fade-up">
                @foreach ($activityEvents->take(3) as $i => $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="activity-card {{ $i === 0 ? 'active' : '' }}">
                        @if ($event->cover_image)
                            <img class="activity-img" src="{{ Media::url($event->cover_image) }}" alt="" />
                        @else
                            <img class="activity-img" src="{{ asset('legacy/img/event'.($i % 3 + 1).'.jpg') }}" alt="" />
                        @endif
                        <div class="activity-info">
                            <h3>{{ $event->title }}</h3>
                            <div class="activity-meta">
                                <span class="activity-date">
                                    @if ($event->starts_at)
                                        {{ $event->starts_at->locale('ar')->translatedFormat('j F Y') }}
                                    @endif
                                </span>
                                <img src="{{ asset('legacy/img/arrow-left.svg') }}" class="activity-arrow" alt="" />
                            </div>
                        </div>
                    </a>
                    @if ($i === 0)
                        <button class="arrow-activty right" type="button" aria-label="التالي">›</button>
                    @endif
                    @if ($i === 1)
                        <button class="arrow-activty left" type="button" aria-label="السابق">‹</button>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="family-stats section-home-motion" data-animate="fade-up">
        <div class="container">
            <h2 class="stats-title gradient-text">إحصائيات العائلة</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-label">إجمالي الإناث</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statFemale) ?: 0 }}">0</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">إجمالي الذكور</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statMale) ?: 0 }}">0</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">على قيد الحياة</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statAlive) ?: 0 }}">0</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">إجمالي عدد الأفراد</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statTotal) ?: 0 }}">0</span>
                </div>
            </div>
            <div class="stats-wide">
                <div class="wide-card">
                    <span class="wide-label">{{ $statWideOneLabel }}</span>
                    <span class="wide-value">{{ $statWideOneValue }}</span>
                </div>
                <div class="wide-card">
                    <span class="wide-label">{{ $statWideTwoLabel }}</span>
                    <span class="wide-value">{{ $statWideTwoValue }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="library-images section-home-motion" data-animate="fade-up">
        <div class="container">
            <section class="landmark-section">
                <div class="landmark-card" data-animate="fade-up" data-delay="100">
                    <button class="nav-arrow" type="button" aria-label="التالي">
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </button>
                    <div class="landmark-content">
                        <h2 class="landmark-title">
                            {{ $landmarkTitle }}
                            <span class="dash"></span>
                        </h2>
                        @if ($landmarkBodyHtml)
                            <div class="landmark-body">{!! $landmarkBodyHtml !!}</div>
                        @else
                            <p>يُدار هذا القسم من لوحة التحكم.</p>
                        @endif
                        <a href="{{ $landmarkMoreUrl }}" class="more-btn">
                            مشاهدة المزيد
                            <span class="btn-arrow" aria-hidden="true">←</span>
                        </a>
                    </div>
                    <div class="landmark-image">
                        <img src="{{ Media::settingImage($landmarkImage ?? null, 'img/jureselem.png') }}" alt="معلم تاريخي" />
                    </div>
                </div>
            </section>
        </div>
    </section>

    <section class="gallery-section">
        <div class="gallery-wrapper">
            <div class="gallery-grid" id="galleryGrid"></div>
        </div>
    </section>

    <div class="lightbox" id="lightbox">
        <span class="close">&times;</span>
        <img id="lightboxImg" alt="Gallery preview" />
    </div>

    <section class="form-section" data-animate="fade-up">
        <div class="form-box">
            <div class="form-info">
                <h2>أضف بياناتك</h2>
                <p>يرجى تعبئة جميع البيانات صحيحة ومحدثة<br />لإضافتها لأرشيف العائلة</p>
                <div class="type-buttons">
                    <button type="button" class="type-btn active" data-archive-type="أفراد">أفراد</button>
                    <button type="button" class="type-btn" data-archive-type="عائلة">عائلة</button>
                    <button type="button" class="type-btn" data-archive-type="مغترب">مغترب</button>
                    <button type="button" class="type-btn" data-archive-type="أخرى">أخرى</button>
                </div>
            </div>

            <form class="form-fields" method="post" action="{{ route('archive-submissions.store') }}">
                @csrf
                <input type="hidden" name="type" id="archiveTypeField" value="أفراد" />
                <div class="field">
                    <label>الاسم بالكامل <span>*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="ادخل الاسم" required />
                </div>
                <div class="field">
                    <label>رقم الجوال <span>*</span></label>
                    <div class="phone-input">
                        <select name="phone_country" aria-label="رمز الدولة">
                            <option value="+970" @selected(old('phone_country', '+970') === '+970')>+970</option>
                            <option value="+972" @selected(old('phone_country') === '+972')>+972</option>
                        </select>
                        <input type="tel" name="phone_number" value="{{ old('phone_number') }}" placeholder="00 000 0000" required />
                    </div>
                </div>
                <div class="field">
                    <label>البريد الإلكتروني <span>*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="ادخل البريد الإلكتروني" required />
                </div>
                <button type="submit" class="submit-btn">إرسال</button>
            </form>
        </div>
    </section>

    @if (! empty($latestNews) && $latestNews->isNotEmpty())
        <section class="section-title" data-animate="fade-up">
            <div class="title-wrapper">
                <span class="line"></span>
                <h2 class="gradient-text">آخر الأخبار</h2>
                <span class="line"></span>
            </div>
        </section>

        <section class="home-latest-news container" data-animate="fade-up">
            <div class="hln-grid">
                @foreach ($latestNews as $post)
                    <a href="{{ route('news.show', $post->slug) }}" class="hln-card">
                        <div class="hln-text">
                            @if ($post->published_at)
                                <span class="hln-date">{{ $post->published_at->locale('ar')->translatedFormat('j F Y') }}</span>
                            @endif
                            <h3 class="hln-title">{{ $post->title }}</h3>
                            @if ($post->excerpt)
                                <p class="hln-excerpt">{{ $post->excerpt }}</p>
                            @endif
                        </div>
                        <div class="hln-media">
                            <img
                                src="{{ $post->featured_image ? Media::url($post->featured_image) : asset('legacy/img/article.jpg') }}"
                                alt="{{ $post->title }}"
                                loading="lazy"
                                width="200"
                                height="160"
                            />
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="hln-all">
                <a href="{{ route('news.index') }}">عرض كل الأخبار <i class="fas fa-arrow-left" aria-hidden="true"></i></a>
            </div>
        </section>
    @endif
@endsection

@push('styles')
<style>
    .home-latest-news { padding: 4px 0 56px; }
    .home-latest-news .hln-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }
    .hln-card {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        gap: 16px;
        background: #f6f1ea;
        border: 1px solid rgba(139, 115, 85, .12);
        border-radius: 16px;
        padding: 16px;
        text-decoration: none;
        color: inherit;
        direction: rtl;
        box-shadow: 0 8px 22px -16px rgba(80, 55, 20, .3);
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .hln-card:hover { transform: translateY(-4px); box-shadow: 0 18px 34px -18px rgba(80, 55, 20, .4); }
    .hln-text {
        flex: 1 1 auto;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-align: center;
        justify-content: center;
    }
    .hln-date { font-size: 12px; color: #8b7355; font-weight: 600; }
    .hln-title {
        margin: 0;
        font-size: 17px;
        font-weight: 800;
        line-height: 1.55;
        color: #4a3527;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .hln-excerpt {
        margin: 0;
        font-size: 13.5px;
        line-height: 1.75;
        color: #6a5b4a;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .hln-media { flex: 0 0 190px; align-self: stretch; }
    .hln-media img {
        width: 100%;
        height: 100%;
        min-height: 130px;
        object-fit: cover;
        border-radius: 12px;
        display: block;
    }
    .hln-all { text-align: center; margin-top: 28px; }
    .hln-all a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #8b7355;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        transition: color .2s ease;
    }
    .hln-all a:hover { color: #4a3527; }

    @media (max-width: 768px) {
        .home-latest-news .hln-grid { grid-template-columns: 1fr; gap: 16px; }
        .hln-card { padding: 12px; gap: 12px; }
        .hln-media { flex-basis: 120px; }
        .hln-media img { min-height: 110px; }
        .hln-title { font-size: 15px; }
        .hln-excerpt { -webkit-line-clamp: 2; }
    }
</style>
@endpush

@push('before_legacy_script')
    <script>
        window.MEDIA_VIDEO_URL = @json($mediaVideoUrl ?: '');
        window.GALLERY_IMAGES = @json($galleryUrls);
    </script>
@endpush

@push('scripts')
    <script>
        document.querySelectorAll('.form-section .type-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var v = btn.getAttribute('data-archive-type');
                var field = document.getElementById('archiveTypeField');
                if (v && field) field.value = v;
            });
        });
    </script>
@endpush
