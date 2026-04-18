@extends('layouts.site')

@section('body_class', 'events-page')

@section('content')
    <section class="detail-view-section">
        <div class="container detail-view-wrap">
            <article class="detail-view" data-animate="fade-up">
                <div class="detail-view__inner">
                    <div class="detail-view__ornament" aria-hidden="true"></div>

                    <header class="detail-view__head">
                        <div class="detail-view__meta-row">
                            @if ($event->starts_at)
                                <time class="detail-view__date" datetime="{{ $event->starts_at->toIso8601String() }}">
                                    {{ $event->starts_at->locale('ar')->translatedFormat('j F Y — H:i') }}
                                </time>
                            @endif
                            <span class="detail-view__chip">فعالية</span>
                        </div>
                        <h1 class="detail-view__title">{{ $event->title }}</h1>
                        @if ($event->location)
                            <p class="detail-view__subtitle">
                                <i class="fas fa-location-dot" aria-hidden="true"></i>
                                {{ $event->location }}
                            </p>
                        @endif
                    </header>

                    @if ($event->cover_image)
                        <figure class="detail-view__media">
                            <img
                                src="{{ \App\Support\Media::url($event->cover_image) }}"
                                alt=""
                                loading="eager"
                                decoding="async"
                                width="880"
                                height="495"
                            />
                        </figure>
                    @endif

                    @if ($event->description)
                        <p class="detail-view__lead">{{ $event->description }}</p>
                    @endif

                    @if ($event->body)
                        <div class="detail-view__body article-text">
                            {!! $event->body !!}
                        </div>
                    @endif

                    @if ($event->detail_url)
                        <p class="detail-view__extra">
                            <a href="{{ $event->detail_url }}" target="_blank" rel="noopener noreferrer">رابط إضافي للتفاصيل</a>
                        </p>
                    @endif

                    <footer class="detail-view__footer">
                        <a href="{{ route('events.index') }}" class="detail-view__back">
                            <i class="fas fa-chevron-right" aria-hidden="true"></i>
                            العودة للفعاليات
                        </a>
                    </footer>
                </div>
            </article>
        </div>
    </section>
@endsection
