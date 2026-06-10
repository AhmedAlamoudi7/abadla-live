@extends('layouts.site')

@php
    use App\Support\Media;
    // Gallery items carry both the image URL and the control-panel caption.
    $galleryItems = $galleryImages->isNotEmpty()
        ? $galleryImages->map(fn ($g) => ['url' => Media::url($g->image), 'caption' => (string) ($g->caption ?? '')])->values()->all()
        : [
            ['url' => asset('legacy/img/library-image.png'), 'caption' => ''],
            ['url' => asset('legacy/img/library-image.png'), 'caption' => ''],
            ['url' => asset('legacy/img/library-image.png'), 'caption' => ''],
        ];

    // Full activity-events pool so the slider can rotate through ALL events (not just the 3 shown).
    $activityCardsData = $activityEvents->values()->map(fn ($e, $idx) => [
        'title' => $e->title,
        'date' => $e->starts_at ? $e->starts_at->locale('ar')->translatedFormat('j F Y') : '',
        'url' => route('events.show', $e->slug),
        'img' => $e->cover_image ? Media::url($e->cover_image) : asset('legacy/img/event'.($idx % 3 + 1).'.jpg'),
    ])->all();
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
                    $slideLink = $slide->link ?? null;
                @endphp
                @if ($slideLink)
                    <a href="{{ $slideLink }}" class="slide {{ $i === 0 ? 'active' : '' }}">
                        <img src="{{ $src }}" loading="lazy" alt="" />
                    </a>
                @else
                    <img src="{{ $src }}" class="slide {{ $i === 0 ? 'active' : '' }}" loading="lazy" alt="" />
                @endif
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

            {{-- احدث الاجتماعيات — latest social occasions --}}
            @if (! empty($latestSocial) && $latestSocial->isNotEmpty())
                <section class="section-title" data-animate="fade-up">
                    <div class="title-wrapper">
                        <span class="line"></span>
                        <h2 class="gradient-text">{{ $socialTitle }}</h2>
                        <span class="line"></span>
                    </div>
                </section>

                <section class="home-latest-social section-home-motion" data-animate="fade-up">
                    <div class="hls-grid">
                        @foreach ($latestSocial as $item)
                            <a href="{{ route('social.show', $item->slug) }}" class="hls-card">
                                <div class="hls-media">
                                    @if ($item->image)
                                        <img src="{{ Media::url($item->image) }}" alt="{{ $item->title }}" loading="lazy" />
                                    @else
                                        <span class="hls-media-fallback"><i class="fas fa-heart" aria-hidden="true"></i></span>
                                    @endif
                                    @if (! empty($item->images) && is_array($item->images) && count($item->images))
                                        <span class="hls-count"><i class="fas fa-images" aria-hidden="true"></i> {{ count($item->images) }}</span>
                                    @endif
                                </div>
                                <div class="hls-text">
                                    @if ($item->occurred_on)
                                        <span class="hls-date">{{ $item->occurred_on->locale('ar')->translatedFormat('j F Y') }}</span>
                                    @endif
                                    <h3 class="hls-title">{{ $item->title }}</h3>
                                    @if ($item->category)
                                        <span class="hls-cat">{{ $item->category->name }}</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="hls-all">
                        <a href="{{ route('social') }}">عرض كل الإجتماعيات <i class="fas fa-arrow-left" aria-hidden="true"></i></a>
                    </div>
                </section>
            @endif

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
                            <div class="media-head"><h3>{{ $videoLabel }}</h3></div>
                            <div class="video-box" data-video-url="{{ e($mediaVideoUrl) }}"><span class="play-btn">▶</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-title" data-animate="fade-up">
                <div class="title-wrapper">
                    <span class="line"></span>
                    <h2 class="gradient-text">{{ $activitiesTitle }}</h2>
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
            <h2 class="stats-title gradient-text">{{ $statsTitle }}</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-label">{{ $statFemaleLabel }}</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statFemale) ?: 0 }}">0</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">{{ $statMaleLabel }}</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statMale) ?: 0 }}">0</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">{{ $statAliveLabel }}</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statAlive) ?: 0 }}">0</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">{{ $statTotalLabel }}</span>
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
        <div class="lightbox-caption" id="lightboxCaption" style="display:none"></div>
    </div>

    <section class="form-section" data-animate="fade-up">
        <div class="form-box">
            <div class="form-info">
                <h2>{{ $archiveTitle }}</h2>
                <p>{!! nl2br(e($archiveHelp)) !!}</p>
                <div class="type-buttons">
                    @foreach ($archiveTypes as $i => $archiveType)
                        <button type="button" class="type-btn {{ $i === 0 ? 'active' : '' }}" data-archive-type="{{ $archiveType }}">{{ $archiveType }}</button>
                    @endforeach
                </div>
            </div>

            <form class="form-fields" method="post" action="{{ route('archive-submissions.store') }}">
                @csrf
                <input type="hidden" name="type" id="archiveTypeField" value="{{ $archiveTypes->first() }}" />
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
                <h2 class="gradient-text">{{ $newsTitle }}</h2>
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
    /* Clickable hero slides: keep the anchor sized like the bare <img> slide */
    .hero-slider a.slide { display: block; height: 100%; }
    .hero-slider a.slide img { width: 100%; height: 100%; object-fit: cover; display: block; }

    /* Gallery lightbox caption (control-panel managed) */
    .lightbox .lightbox-caption {
        margin-top: 14px;
        max-width: 90vw;
        color: #fff;
        font-size: 16px;
        line-height: 1.7;
        text-align: center;
        direction: rtl;
        text-shadow: 0 2px 8px rgba(0, 0, 0, .6);
    }

    .home-latest-news { padding-top: 4px; padding-bottom: 56px; }
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

    /* احدث الاجتماعيات — latest social occasions */
    .home-latest-social { padding: 4px 0 8px; }
    .home-latest-social .hls-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }
    .hls-card {
        display: flex;
        flex-direction: column;
        background: #f6f1ea;
        border: 1px solid rgba(139, 115, 85, .12);
        border-radius: 16px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 8px 22px -16px rgba(80, 55, 20, .3);
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .hls-card:hover { transform: translateY(-4px); box-shadow: 0 18px 34px -18px rgba(80, 55, 20, .4); }
    .hls-media { position: relative; aspect-ratio: 16 / 11; background: #efe7db; overflow: hidden; }
    .hls-media img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .4s ease; }
    .hls-card:hover .hls-media img { transform: scale(1.05); }
    .hls-media-fallback {
        display: flex; align-items: center; justify-content: center;
        width: 100%; height: 100%; color: #c9b79c; font-size: 36px;
    }
    .hls-count {
        position: absolute; inset-inline-end: 8px; bottom: 8px;
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 999px;
        background: rgba(26, 19, 16, .62); color: #fff; font-size: 12px; font-weight: 600;
    }
    .hls-text { padding: 14px 16px 16px; display: flex; flex-direction: column; gap: 8px; text-align: center; }
    .hls-date { font-size: 12px; color: #8b7355; font-weight: 600; }
    .hls-title {
        margin: 0; font-size: 16px; font-weight: 800; line-height: 1.55; color: #4a3527;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .hls-cat {
        align-self: center; display: inline-block; margin-top: 2px;
        padding: 3px 12px; border-radius: 999px;
        background: rgba(139, 115, 85, .12); color: #6a5b4a; font-size: 12px; font-weight: 600;
    }
    .hls-all { text-align: center; margin-top: 26px; }
    .hls-all a {
        display: inline-flex; align-items: center; gap: 8px;
        color: #8b7355; font-weight: 700; font-size: 15px; text-decoration: none;
        transition: color .2s ease;
    }
    .hls-all a:hover { color: #4a3527; }
    @media (max-width: 900px) { .home-latest-social .hls-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 600px) { .home-latest-social .hls-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@push('before_legacy_script')
    <script>
        window.MEDIA_VIDEO_URL = @json($mediaVideoUrl ?: '');
        window.GALLERY_IMAGES = @json($galleryItems);
        window.ACTIVITY_EVENTS = @json($activityCardsData);
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
