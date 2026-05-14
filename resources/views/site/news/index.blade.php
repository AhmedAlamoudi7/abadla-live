@extends('layouts.site')

@php
    use App\Support\Media;
    $fallbackImg = asset('legacy/img/article.jpg');
    $tileImg = function ($post) use ($fallbackImg) {
        if (! $post) {
            return $fallbackImg;
        }
        return $post->featured_image ? Media::url($post->featured_image, $fallbackImg) : $fallbackImg;
    };
    $postDate = function ($post) {
        if (! $post || ! $post->published_at) {
            return '';
        }
        return $post->published_at->locale('ar')->translatedFormat('H:i a — Y-m-d');
    };
    $postDateShort = function ($post) {
        if (! $post || ! $post->published_at) {
            return '';
        }
        return $post->published_at->locale('ar')->translatedFormat('Y . m . d');
    };
    $postTime = function ($post) {
        if (! $post || ! $post->published_at) {
            return '';
        }
        return $post->published_at->locale('ar')->translatedFormat('h:i a');
    };
    $postDay = function ($post) {
        if (! $post || ! $post->published_at) {
            return '';
        }
        return $post->published_at->locale('ar')->translatedFormat('j F Y');
    };
@endphp

@section('body_class', 'news-page')

@section('content')
    @if ($showFullLayout)
        <section class="np-banners container" data-animate="fade-up">
            @forelse ($banners->take(2) as $i => $banner)
                <a href="{{ $banner->link ?: '#' }}" class="np-banner {{ $i === 1 ? 'np-banner--dark' : '' }}">
                    @if ($banner->image)
                        <img src="{{ Media::url($banner->image) }}" alt="" class="np-banner-img" loading="lazy" width="1200" height="286" />
                    @else
                        <img src="{{ asset('legacy/img/banner'.($i + 1).'.jpg') }}" alt="" class="np-banner-img" loading="lazy" width="1200" height="286" />
                    @endif
                    <div class="np-banner-overlay {{ $i === 1 ? 'np-banner-overlay--dark' : '' }}"></div>
                    <p class="np-banner-caption">{{ $banner->caption ?: '—' }}</p>
                </a>
            @empty
                <a href="{{ route('news.index') }}" class="np-banner">
                    <img src="{{ asset('legacy/img/banner.jpg') }}" alt="" class="np-banner-img" loading="lazy" width="1200" height="286" />
                    <div class="np-banner-overlay"></div>
                    <p class="np-banner-caption">أخبار العائلة</p>
                </a>
                <a href="{{ route('news.index') }}" class="np-banner np-banner--dark">
                    <img src="{{ asset('legacy/img/banner2.jpg') }}" alt="" class="np-banner-img" loading="lazy" width="1200" height="286" />
                    <div class="np-banner-overlay np-banner-overlay--dark"></div>
                    <p class="np-banner-caption">متابعة آخر المستجدات</p>
                </a>
            @endforelse
        </section>

        <section class="np-mosaic container" data-animate="fade-up">
            @if ($mosaicHero)
                <a href="{{ route('news.show', $mosaicHero->slug) }}" class="np-tile np-tile--hero">
                    <img src="{{ $tileImg($mosaicHero) }}" alt="" class="np-tile-img" loading="lazy" width="800" height="900" />
                    <span class="np-tile-tag">{{ $mosaicHero->category ?: 'أخبار رئيسية' }}</span>
                    <div class="np-tile-gradient"></div>
                    <div class="np-tile-body">
                        <h3 class="np-tile-title">{{ $mosaicHero->title }}</h3>
                        <p class="np-tile-meta">
                            @if ($mosaicHero->published_at)
                                <span class="np-meta-time">{{ $postTime($mosaicHero) }}</span>
                                <span class="np-meta-sep" aria-hidden="true"></span>
                                <span class="np-meta-date">{{ $postDay($mosaicHero) }}</span>
                            @endif
                            <i class="far fa-clock" aria-hidden="true"></i>
                        </p>
                    </div>
                </a>
            @endif

            <div class="np-mosaic-side">
                @if ($mosaicMid)
                    <a href="{{ route('news.show', $mosaicMid->slug) }}" class="np-tile np-tile--mid">
                        <img src="{{ $tileImg($mosaicMid) }}" alt="" class="np-tile-img" loading="lazy" width="600" height="400" />
                        <span class="np-tile-tag">{{ $mosaicMid->category ?: 'أخبار رئيسية' }}</span>
                        <div class="np-tile-gradient"></div>
                        <div class="np-tile-body">
                            <h3 class="np-tile-title">{{ $mosaicMid->title }}</h3>
                            <p class="np-tile-meta">
                                @if ($mosaicMid->published_at)
                                    <span class="np-meta-time">{{ $postTime($mosaicMid) }}</span>
                                    <span class="np-meta-sep" aria-hidden="true"></span>
                                    <span class="np-meta-date">{{ $postDay($mosaicMid) }}</span>
                                @endif
                                <i class="far fa-clock" aria-hidden="true"></i>
                            </p>
                        </div>
                    </a>
                @endif

                <div class="np-mosaic-pair">
                    @if ($mosaicSm1)
                        <a href="{{ route('news.show', $mosaicSm1->slug) }}" class="np-tile np-tile--sm">
                            <img src="{{ $tileImg($mosaicSm1) }}" alt="" class="np-tile-img" loading="lazy" width="400" height="300" />
                            <span class="np-tile-tag">{{ $mosaicSm1->category ?: 'أخبار' }}</span>
                            <div class="np-tile-gradient"></div>
                            <div class="np-tile-body">
                                <h3 class="np-tile-title">{{ $mosaicSm1->title }}</h3>
                                <p class="np-tile-meta">
                                    @if ($mosaicSm1->published_at)
                                        <span class="np-meta-time">{{ $postTime($mosaicSm1) }}</span>
                                        <span class="np-meta-sep" aria-hidden="true"></span>
                                        <span class="np-meta-date">{{ $postDay($mosaicSm1) }}</span>
                                    @endif
                                    <i class="far fa-clock" aria-hidden="true"></i>
                                </p>
                            </div>
                        </a>
                    @endif
                    @if ($mosaicSm2)
                        <a href="{{ route('news.show', $mosaicSm2->slug) }}" class="np-tile np-tile--sm">
                            <img src="{{ $tileImg($mosaicSm2) }}" alt="" class="np-tile-img" loading="lazy" width="400" height="300" />
                            <span class="np-tile-tag">{{ $mosaicSm2->category ?: 'أخبار' }}</span>
                            <div class="np-tile-gradient"></div>
                            <div class="np-tile-body">
                                <h3 class="np-tile-title">{{ $mosaicSm2->title }}</h3>
                                <p class="np-tile-meta">
                                    @if ($mosaicSm2->published_at)
                                        <span class="np-meta-time">{{ $postTime($mosaicSm2) }}</span>
                                        <span class="np-meta-sep" aria-hidden="true"></span>
                                        <span class="np-meta-date">{{ $postDay($mosaicSm2) }}</span>
                                    @endif
                                    <i class="far fa-clock" aria-hidden="true"></i>
                                </p>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <section class="np-panels container" data-animate="fade-up">
            <article class="np-panel np-panel--featured">
                <header class="np-panel-head">
                    <span class="np-panel-accent" aria-hidden="true"></span>
                    <h2 class="np-panel-title">أخبار الساعة</h2>
                </header>
                @if ($hourlyPost)
                    <a href="{{ route('news.show', $hourlyPost->slug) }}" class="np-panel-feature">
                        <div class="np-panel-feature-media">
                            <img src="{{ $tileImg($hourlyPost) }}" alt="" loading="lazy" width="800" height="450" />
                        </div>
                        <h3 class="np-panel-feature-title">{{ $hourlyPost->title }}</h3>
                        <p class="np-panel-feature-meta">
                            @if ($hourlyPost->published_at)
                                <span class="np-meta-time">{{ $postTime($hourlyPost) }}</span>
                                <span class="np-meta-sep" aria-hidden="true"></span>
                                <span class="np-meta-date">{{ $postDay($hourlyPost) }}</span>
                            @endif
                            <i class="far fa-clock" aria-hidden="true"></i>
                        </p>
                    </a>
                @else
                    <p class="np-panel-feature-title" style="padding:24px;text-align:center;opacity:.8;">لا يوجد خبر مميّز لأخبار الساعة حالياً.</p>
                @endif
            </article>

            <article class="np-panel">
                <header class="np-panel-head np-panel-head--split">
                    <div class="np-panel-head-start">
                        <span class="np-panel-accent" aria-hidden="true"></span>
                        <h2 class="np-panel-title">أهم الأخبار</h2>
                    </div>
                    <i class="fas fa-file-lines np-panel-doc" aria-hidden="true"></i>
                </header>
                <div class="np-panel-list">
                    @forelse ($importantPosts->take(6) as $post)
                        <a href="{{ route('news.show', $post->slug) }}" class="np-panel-row">
                            <div class="np-panel-row-media">
                                <img src="{{ $tileImg($post) }}" alt="" loading="lazy" width="120" height="120" />
                            </div>
                            <h3 class="np-panel-row-title">{{ $post->title }}</h3>
                            <p class="np-panel-row-meta">
                                @if ($post->published_at)
                                    <span class="np-meta-time">{{ $postTime($post) }}</span>
                                    <span class="np-meta-sep" aria-hidden="true"></span>
                                    <span class="np-meta-date">{{ $postDay($post) }}</span>
                                @endif
                                <i class="far fa-clock" aria-hidden="true"></i>
                            </p>
                        </a>
                    @empty
                        <p style="padding:16px;text-align:center;opacity:.85;">لا توجد أخبار في هذه القائمة بعد.</p>
                    @endforelse
                </div>
            </article>
        </section>
    @endif

    <section class="np-grid-section container" data-animate="fade-up">
        <div class="np-grid">
            @forelse ($news as $post)
                <a href="{{ route('news.show', $post->slug) }}" class="np-list-card">
                    <div class="np-list-thumb">
                        <img src="{{ $tileImg($post) }}" alt="" loading="lazy" width="120" height="120" />
                    </div>
                    <div class="np-list-body">
                        <h4>{{ $post->title }}</h4>
                        <p class="np-list-meta">
                            @if ($post->published_at)
                                <span class="np-meta-time">{{ $postTime($post) }}</span>
                                <span class="np-meta-sep" aria-hidden="true"></span>
                                <span class="np-meta-date">{{ $postDay($post) }}</span>
                            @endif
                            <i class="far fa-clock" aria-hidden="true"></i>
                        </p>
                    </div>
                </a>
            @empty
                <p style="grid-column:1/-1;text-align:center;padding:24px;">لا توجد أخبار إضافية للعرض.</p>
            @endforelse
        </div>

        <div class="container" style="padding:24px 0 48px;">
            {{ $news->links('pagination.np') }}
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* ============================================================
           News page — Figma refinements (CONIZY node 494-764)
           Scoped to .news-page so other pages stay untouched.
           ============================================================ */

        /* --- Category tag pill (الأخبار الرئيسية) --- */
        .news-page .np-tile-tag {
            top: 16px;
            right: 16px;
            padding: 4px 18px;
            border-radius: 999px;
            background: var(--brown-light);
            color: #fff;
            font-family: var(--font-serif);
            font-weight: 800;
            font-size: 13px;
            line-height: 1.6;
            letter-spacing: 0;
            box-shadow: 0 2px 8px rgba(86, 60, 47, 0.18);
        }

        /* --- Mosaic tile titles (hero/mid/sm) ----------------------- */
        .news-page .np-tile-title {
            font-family: var(--font-serif);
            font-weight: 700;
            line-height: 1.45;
        }
        .news-page .np-tile--hero .np-tile-title {
            font-size: clamp(20px, 1.9vw, 28px);
        }
        .news-page .np-tile--mid .np-tile-title {
            font-size: clamp(17px, 1.5vw, 22px);
        }
        .news-page .np-tile--sm .np-tile-title {
            font-size: clamp(14px, 1.2vw, 17px);
        }
        .news-page .np-tile-body {
            padding: 20px 22px 22px;
        }
        .news-page .np-tile-gradient {
            background: linear-gradient(
                to top,
                rgba(0, 0, 0, 0.88) 0%,
                rgba(0, 0, 0, 0.45) 38%,
                rgba(0, 0, 0, 0.05) 70%,
                transparent 100%
            );
        }

        /* --- Panels (أهم الأخبار + أخبار الساعة) ------------------- */
        .news-page .np-panel {
            background: transparent;
            border: 1px solid var(--brown-light);
            border-radius: 16px;
            padding: 26px 28px 28px;
            box-shadow: none;
        }
        .news-page .np-panel-accent {
            width: 7px;
            min-height: 24px;
            border-radius: 24px;
            background: var(--brown-light);
        }
        .news-page .np-panel-title {
            font-family: var(--font-serif);
            font-weight: 600;
            font-size: clamp(18px, 1.5vw, 22px);
            color: var(--dark);
            line-height: 1.4;
        }
        .news-page .np-panel-doc {
            font-size: 20px;
            color: var(--brown-light);
            opacity: 1;
        }

        /* Featured (أخبار الساعة) */
        .news-page .np-panel-feature-title {
            font-family: var(--font-serif);
            font-weight: 700;
            font-size: clamp(16px, 1.4vw, 20px);
            color: var(--dark);
            line-height: 1.5;
        }

        /* Row list (أهم الأخبار) — vertical stack: image → title → meta */
        .news-page .np-panel-row {
            display: block;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(187, 161, 136, 0.35);
        }
        .news-page .np-panel-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .news-page .np-panel-row-media {
            margin-bottom: 16px;
            aspect-ratio: 16 / 10;
            border-radius: 16px;
            overflow: hidden;
            background: var(--brown-pale);
        }
        .news-page .np-panel-row-title {
            margin: 0 0 10px;
            font-family: var(--font-serif);
            font-weight: 400;
            font-size: clamp(15px, 1.3vw, 20px);
            color: #000;
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .news-page .np-panel-row-meta {
            color: #000;
            justify-content: flex-end;
        }

        /* --- Bottom grid (3 columns × 2 rows like Figma) ------------ */
        .news-page .np-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 24px 32px;
        }
        /* RTL: column 1 = right (thumb), column 2 = left (body) */
        .news-page .np-list-card {
            display: grid;
            grid-template-columns: 97px 1fr;
            gap: 18px;
            align-items: start;
            padding: 8px 4px;
            background: transparent;
            border: none;
            border-radius: 0;
        }
        .news-page .np-list-card:hover {
            transform: none;
            box-shadow: none;
            opacity: 0.92;
        }
        .news-page .np-list-thumb {
            grid-column: 1;
            grid-row: 1 / span 2;
            width: 97px;
            height: 97px;
            border-radius: 16px;
            background: var(--brown-pale);
        }
        .news-page .np-list-body {
            grid-column: 2;
            grid-row: 1 / span 2;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 97px;
        }
        .news-page .np-list-body h4 {
            margin: 0 0 10px;
            font-family: var(--font-serif);
            font-weight: 400;
            font-size: clamp(14px, 1.2vw, 18px);
            color: #000;
            line-height: 1.5;
            -webkit-line-clamp: 3;
            line-clamp: 3;
        }
        .news-page .np-list-meta {
            color: #000;
        }

        /* --- Meta row: time | divider | date | clock ---------------- */
        .news-page .np-tile-meta,
        .news-page .np-panel-feature-meta,
        .news-page .np-panel-row-meta,
        .news-page .np-list-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            margin: 0;
            font-family: 'Montserrat', 'Tahoma', sans-serif;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.6;
        }
        .news-page .np-meta-time {
            order: 1;
        }
        .news-page .np-meta-sep {
            order: 2;
            width: 1px;
            height: 13px;
            background: var(--brown-light);
            border-radius: 2px;
            opacity: 0.9;
        }
        .news-page .np-meta-date {
            order: 3;
        }
        .news-page .np-tile-meta .np-meta-sep,
        .news-page .np-panel-feature .np-meta-sep {
            background: rgba(255, 255, 255, 0.9);
        }
        .news-page .np-tile-meta i,
        .news-page .np-panel-feature-meta i,
        .news-page .np-panel-row-meta i,
        .news-page .np-list-meta i {
            order: 4;
            font-size: 12px;
            color: var(--brown-light);
        }
        .news-page .np-tile-meta i {
            color: #fff;
        }

        /* --- Responsive: keep things sane on smaller screens -------- */
        @media (max-width: 1200px) {
            .news-page .np-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .news-page .np-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }
            .news-page .np-panel {
                padding: 18px 18px 20px;
            }
            .news-page .np-list-card {
                grid-template-columns: 80px 1fr;
                gap: 12px;
            }
            .news-page .np-list-thumb {
                width: 80px;
                height: 80px;
            }
        }
    </style>
@endpush
