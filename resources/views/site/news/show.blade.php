@extends('layouts.site')

@section('body_class', 'news-page')

@section('content')
    <section class="detail-view-section">
        <div class="container detail-view-wrap">
            <article class="detail-view" data-animate="fade-up">
                <div class="detail-view__inner">
                    <div class="detail-view__ornament" aria-hidden="true"></div>

                    <header class="detail-view__head">
                        <div class="detail-view__meta-row">
                            @if ($post->published_at)
                                <time class="detail-view__date" datetime="{{ $post->published_at->toIso8601String() }}">
                                    {{ $post->published_at->locale('ar')->translatedFormat('j F Y') }}
                                </time>
                            @endif
                            @if ($post->category)
                                <span class="detail-view__chip">{{ $post->category }}</span>
                            @endif
                        </div>
                        <h1 class="detail-view__title">{{ $post->title }}</h1>
                    </header>

                    @if ($post->featured_image)
                        <figure class="detail-view__media">
                            <img
                                src="{{ \App\Support\Media::url($post->featured_image) }}"
                                alt=""
                                loading="eager"
                                decoding="async"
                                width="880"
                                height="495"
                            />
                        </figure>
                    @endif

                    @if ($post->excerpt)
                        <p class="detail-view__lead">{{ $post->excerpt }}</p>
                    @endif

                    <div class="detail-view__body article-text">
                        {!! $post->body !!}
                    </div>

                    <footer class="detail-view__footer">
                        <a href="{{ route('news.index') }}" class="detail-view__back">
                            <i class="fas fa-chevron-right" aria-hidden="true"></i>
                            العودة للأخبار
                        </a>
                    </footer>
                </div>
            </article>
        </div>
    </section>
@endsection
