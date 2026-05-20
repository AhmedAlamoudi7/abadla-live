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

        <div class="events-carousel" data-events-carousel>
            <button class="carousel-arrow carousel-arrow-prev" type="button" aria-label="السابق">
                <img src="{{ asset('legacy/img/Frame 49.png') }}" alt="" />
            </button>
            <div class="carousel-viewport">
                <div class="carousel-track">
                    @forelse ($events as $i => $event)
                        <a href="{{ route('events.show', $event->slug) }}" class="event-item">
                            <div class="event-image" @if ($event->cover_image)
                                style="background-image:url('{{ \App\Support\Media::url($event->cover_image) }}')"
                            @else
                                style="background-image:url('{{ asset('legacy/img/event'.($i % 3 + 1).'.jpg') }}')"
                            @endif>
                                <div class="event-overlay"></div>
                            </div>
                            <div class="event-pill">
                                <div class="event-pill-text">
                                    <div class="event-pill-title">{{ $event->title }}</div>
                                    <div class="event-pill-date">
                                        @if ($event->starts_at)
                                            {{ $event->starts_at->locale('ar')->translatedFormat('j F Y') }}
                                        @endif
                                    </div>
                                </div>
                                <span class="event-pill-arrow" aria-hidden="true">
                                    <img src="{{ asset('legacy/img/arrow-left.svg') }}" alt="" />
                                </span>
                            </div>
                        </a>
                    @empty
                        <p style="grid-column:1/-1;text-align:center;padding:24px;">لا توجد فعاليات منشورة بعد.</p>
                    @endforelse
                </div>
            </div>
            <button class="carousel-arrow carousel-arrow-next" type="button" aria-label="التالي">
                <img src="{{ asset('legacy/img/Frame 48.png') }}" alt="" />
            </button>
        </div>

        <div class="container" style="padding:24px 0;">
            {{ $events->links('pagination.np') }}
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function () {
        var carousels = document.querySelectorAll('[data-events-carousel]');
        carousels.forEach(function (carousel) {
            var viewport = carousel.querySelector('.carousel-viewport');
            var track = carousel.querySelector('.carousel-track');
            var prev = carousel.querySelector('.carousel-arrow-prev');
            var next = carousel.querySelector('.carousel-arrow-next');
            if (!viewport || !track || !prev || !next) return;

            function step() {
                var item = track.querySelector('.event-item');
                if (!item) return 300;
                var style = getComputedStyle(track);
                var gap = parseFloat(style.columnGap || style.gap) || 0;
                return item.getBoundingClientRect().width + gap;
            }

            prev.addEventListener('click', function () {
                viewport.scrollBy({ left: -step(), behavior: 'smooth' });
            });
            next.addEventListener('click', function () {
                viewport.scrollBy({ left: step(), behavior: 'smooth' });
            });
        });
    })();
</script>
@endpush
