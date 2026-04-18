@extends('layouts.site')

@section('content')
    <section class="container" style="padding:40px 0 20px;" data-animate="fade-up">
        <div class="content-frame content-frame--page-header">
            <h1 class="gradient-text" style="text-align:center;">أخبار العائلة</h1>
            @if ($intro)
                <div class="article-text" style="max-width:800px;margin:16px auto 0;">{!! $intro !!}</div>
            @endif
        </div>
    </section>

    <section class="news-section" data-animate="fade-up">
        <div class="news-grid">
            @forelse ($news as $post)
                <article class="news-card">
                    <div class="news-text">
                        <span class="news-date">{{ optional($post->published_at)->locale('ar')->translatedFormat('j F Y') }}</span>
                        <h3><a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a></h3>
                        <p>{{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags((string) $post->body), 160) }}</p>
                    </div>
                    <div class="news-image">
                        @if ($post->featured_image)
                            <img src="{{ \App\Support\Media::url($post->featured_image) }}" alt="" />
                        @else
                            <i class="fas fa-image"></i>
                        @endif
                    </div>
                </article>
            @empty
                <p style="grid-column:1/-1;text-align:center;">لا توجد أخبار منشورة بعد.</p>
            @endforelse
        </div>
        <div class="container" style="padding:24px 0;">
            {{ $news->links() }}
        </div>
    </section>
@endsection
