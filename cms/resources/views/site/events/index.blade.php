@extends('layouts.site')

@section('content')
    <section class="container" style="padding:40px 0 20px;" data-animate="fade-up">
        <div class="content-frame content-frame--page-header">
            <h1 class="gradient-text" style="text-align:center;">فعاليات</h1>
            @if ($intro1)
                <div class="article-text" style="max-width:800px;margin:12px auto 0;text-align:center;">{!! $intro1 !!}</div>
            @endif
            @if ($intro2)
                <div class="article-text" style="max-width:800px;margin:8px auto 0;text-align:center;">{!! $intro2 !!}</div>
            @endif
        </div>
    </section>

    <section class="family-events">
        <div class="container">
            <div class="events-row" data-animate="fade-up">
                @forelse ($events as $i => $event)
                    <div class="event-card {{ $i === 0 ? 'active' : '' }}">
                        <span class="event-date">
                            @if ($event->starts_at)
                                {{ $event->starts_at->locale('ar')->translatedFormat('j F Y') }}
                            @endif
                        </span>
                        <h3>{{ $event->title }}</h3>
                        <p>{{ $event->location }}</p>
                        @if ($event->cover_image)
                            <img src="{{ \App\Support\Media::url($event->cover_image) }}" alt="" />
                        @else
                            <img src="{{ asset('legacy/img/event'.($i % 3 + 1).'.jpg') }}" alt="" />
                        @endif
                        <a class="event-btn" href="{{ route('events.show', $event->slug) }}">مشاهدة المزيد <img src="{{ asset('legacy/img/arrow-left.svg') }}" class="btn-icon" alt="" /></a>
                    </div>
                    @if ($i === 0)
                        <button type="button" class="arrow right" aria-label="التالي">›</button>
                    @endif
                    @if ($i === 1)
                        <button type="button" class="arrow left" aria-label="السابق">‹</button>
                    @endif
                @empty
                    <p style="text-align:center;">لا توجد فعاليات منشورة بعد.</p>
                @endforelse
            </div>
        </div>
    </section>

    <div class="container" style="padding:24px 0;">
        {{ $events->links() }}
    </div>
@endsection
