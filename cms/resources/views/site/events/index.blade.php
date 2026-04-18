@extends('layouts.site')

@section('body_class', 'events-page')

@section('content')
    <section class="evt-intro container" data-animate="fade-up">
        <h1 class="evt-title gradient-text" style="text-align:center;">فعاليات</h1>
        @if ($intro1)
            <p class="evt-desc">{!! $intro1 !!}</p>
        @endif
        @if ($intro2)
            <p class="evt-desc">{!! $intro2 !!}</p>
        @endif
        <div class="evt-intro-rule" aria-hidden="true"></div>
    </section>

    <section class="evt-browse container" data-animate="fade-up">
        <div class="title-wrapper evt-browse-title-wrap">
            <h2 class="gradient-text">تصفح الفعاليات</h2>
        </div>

        <div class="evt-grid-wrap">
            <div class="evt-grid">
                @forelse ($events as $i => $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="evt-card">
                        @if ($event->cover_image)
                            <img class="evt-card-img" src="{{ \App\Support\Media::url($event->cover_image) }}" alt="" loading="lazy" />
                        @else
                            <img class="evt-card-img" src="{{ asset('legacy/img/event'.($i % 3 + 1).'.jpg') }}" alt="" loading="lazy" />
                        @endif
                        <div class="evt-card-overlay">
                            <div class="evt-card-copy">
                                <h3>{{ $event->title }}</h3>
                                <p class="evt-card-date">
                                    @if ($event->starts_at)
                                        {{ $event->starts_at->locale('ar')->translatedFormat('j F Y') }}
                                    @endif
                                    @if ($event->location)
                                        — {{ $event->location }}
                                    @endif
                                </p>
                            </div>
                            <span class="evt-card-arrow-icon" aria-hidden="true">
                                <img src="{{ asset('legacy/img/arrow-left.svg') }}" alt="" />
                            </span>
                        </div>
                    </a>
                @empty
                    <p style="grid-column:1/-1;text-align:center;">لا توجد فعاليات منشورة بعد.</p>
                @endforelse
            </div>
        </div>

        <div class="container" style="padding:24px 0;">
            {{ $events->links() }}
        </div>
    </section>
@endsection
