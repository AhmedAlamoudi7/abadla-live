@extends('layouts.site')

@section('content')
    <article class="container content-frame content-frame--article" style="padding:48px 0;max-width:880px;" data-animate="fade-up">
        <header style="margin-bottom:24px;">
            <span class="news-date">{{ optional($post->published_at)->locale('ar')->translatedFormat('j F Y') }}</span>
            <h1 style="margin-top:12px;font-size:1.75rem;">{{ $post->title }}</h1>
        </header>
        @if ($post->featured_image)
            <div class="news-detail-featured">
                <img src="{{ \App\Support\Media::url($post->featured_image) }}" alt="" />
            </div>
        @endif
        <div class="article-text" style="line-height:1.9;">
            {!! $post->body !!}
        </div>
        <p style="margin-top:32px;">
            <a href="{{ route('news.index') }}">← العودة للأخبار</a>
        </p>
    </article>
@endsection
