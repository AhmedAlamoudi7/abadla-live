@extends('layouts.site')

@section('body_class', 'events-page events-page-tech')

@section('content')
    <section class="evt-tech-page">
        <div class="evt-tech-canvas">
            <div class="text-wrapper">تصفح الفعاليات</div>
            <p class="p">فعاليات عائلتنا .. لحظات تصنع وتبقى</p>

            <div class="events-carousel">
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
                                    <div class="frame-10">
                                        <div class="text-wrapper-2">{{ $event->title }}</div>
                                        <div class="text-wrapper-3">
                                            @if ($event->starts_at)
                                                {{ $event->starts_at->locale('ar')->translatedFormat('j F Y') }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="button">
                                        <div class="vector-wrapper">
                                            <img class="vector" src="{{ asset('legacy/img/Frame.svg') }}" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p style="padding:24px;text-align:center;width:100%;">لا توجد فعاليات منشورة بعد.</p>
                        @endforelse
                    </div>
                </div>
                <button class="carousel-arrow carousel-arrow-next" type="button" aria-label="التالي">
                    <img src="{{ asset('legacy/img/Frame 48.png') }}" alt="" />
                </button>
            </div>

            <div class="pagination">
                {{ $events->links('pagination.np') }}
            </div>

            <p class="text-wrapper-4">
                @if ($intro1)
                    {!! $intro1 !!}
                @endif
                @if ($intro2)
                    <br /><br />{!! $intro2 !!}
                @endif
            </p>

            <img class="vector-4" src="{{ asset('legacy/img/Vector-5.svg') }}" alt="" />
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function () {
        var carousel = document.querySelector('.evt-tech-page .events-carousel');
        if (!carousel) return;
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
    })();
</script>
@endpush
