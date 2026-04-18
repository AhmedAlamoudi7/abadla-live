@extends('layouts.site')

@section('content')
    <article class="container content-frame content-frame--article" style="padding:48px 0;max-width:880px;" data-animate="fade-up">
        @if ($event->cover_image)
            <div class="event-detail-cover">
                <img src="{{ \App\Support\Media::url($event->cover_image) }}" alt="" />
            </div>
        @endif
        <h1 style="font-size:1.75rem;margin-bottom:12px;">{{ $event->title }}</h1>
        <p style="opacity:.85;margin-bottom:8px;">
            @if ($event->starts_at)
                {{ $event->starts_at->locale('ar')->translatedFormat('j F Y H:i') }}
            @endif
            @if ($event->location)
                — {{ $event->location }}
            @endif
        </p>
        @if ($event->description)
            <p class="article-text">{{ $event->description }}</p>
        @endif
        @if ($event->body)
            <div class="article-text" style="margin-top:24px;line-height:1.9;">{!! $event->body !!}</div>
        @endif
        @if ($event->detail_url)
            <p style="margin-top:24px;"><a href="{{ $event->detail_url }}" target="_blank" rel="noopener">رابط إضافي</a></p>
        @endif
        <p style="margin-top:32px;">
            <a href="{{ route('events.index') }}">← العودة للفعاليات</a>
        </p>
    </article>
@endsection
