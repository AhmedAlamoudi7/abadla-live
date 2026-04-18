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
                        <p class="np-tile-meta"><i class="far fa-clock" aria-hidden="true"></i><span>{{ $postDate($mosaicHero) }}</span></p>
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
                            <p class="np-tile-meta"><i class="far fa-clock" aria-hidden="true"></i><span>{{ $postDate($mosaicMid) }}</span></p>
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
                                <p class="np-tile-meta"><i class="far fa-clock" aria-hidden="true"></i><span>{{ $postDate($mosaicSm1) }}</span></p>
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
                                <p class="np-tile-meta"><i class="far fa-clock" aria-hidden="true"></i><span>{{ $postDate($mosaicSm2) }}</span></p>
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
                        <p class="np-panel-feature-meta"><i class="far fa-clock" aria-hidden="true"></i><span>{{ $postDate($hourlyPost) }}</span></p>
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
                            <p class="np-panel-row-meta"><i class="far fa-clock" aria-hidden="true"></i><span>{{ $post->published_at ? $post->published_at->format('Y-m-d') : '' }}</span></p>
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
                        <img src="{{ $tileImg($post) }}" alt="" loading="lazy" width="400" height="300" />
                    </div>
                    <div class="np-list-body">
                        <h4>{{ $post->title }}</h4>
                        <p class="np-list-meta"><i class="far fa-clock" aria-hidden="true"></i><span>{{ $postDateShort($post) }}</span></p>
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
        .np-panel-feature-media img,
        .np-panel-row-media img,
        .np-list-thumb img {
            object-fit: cover;
        }
    </style>
@endpush
