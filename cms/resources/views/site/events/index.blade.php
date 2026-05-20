@extends('layouts.site')

@section('body_class', 'events-page')

@section('content')
    <section class="evt2 container" data-animate="fade-up">
        <h2 class="evt2-tagline">فعاليات عائلتنا .. لحظات تصنع وتبقى</h2>

        <p class="evt2-desc">
            @if ($intro1)
                {!! $intro1 !!}
            @endif
            @if ($intro2)
                <br /><br />{!! $intro2 !!}
            @endif
        </p>

        <hr class="evt2-divider" aria-hidden="true" />

        <h3 class="evt2-heading">تصفح الفعاليات</h3>

        <div class="evt2-carousel" data-evt2-carousel>
            <button class="evt2-arrow evt2-arrow-prev" type="button" aria-label="السابق">
                <img src="{{ asset('legacy/img/Frame 49.png') }}" alt="" />
            </button>

            <div class="evt2-viewport">
                <div class="evt2-track">
                    @forelse ($events as $i => $event)
                        <a href="{{ route('events.show', $event->slug) }}" class="evt2-card">
                            <div class="evt2-card-image" @if ($event->cover_image)
                                style="background-image:url('{{ \App\Support\Media::url($event->cover_image) }}')"
                            @else
                                style="background-image:url('{{ asset('legacy/img/event'.($i % 3 + 1).'.jpg') }}')"
                            @endif></div>
                            <div class="evt2-card-pill">
                                <div class="evt2-card-text">
                                    <div class="evt2-card-title">{{ $event->title }}</div>
                                    <div class="evt2-card-date">
                                        @if ($event->starts_at)
                                            {{ $event->starts_at->locale('ar')->translatedFormat('j F Y') }}
                                        @endif
                                    </div>
                                </div>
                                <span class="evt2-card-arrow" aria-hidden="true">
                                    <img src="{{ asset('legacy/img/arrow-left.svg') }}" alt="" />
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="evt2-empty">لا توجد فعاليات منشورة بعد.</p>
                    @endforelse
                </div>
            </div>

            <button class="evt2-arrow evt2-arrow-next" type="button" aria-label="التالي">
                <img src="{{ asset('legacy/img/Frame 48.png') }}" alt="" />
            </button>
        </div>

        <div class="evt2-pagination">
            {{ $events->links('pagination.np') }}
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function () {
        var carousels = document.querySelectorAll('[data-evt2-carousel]');
        carousels.forEach(function (carousel) {
            var viewport = carousel.querySelector('.evt2-viewport');
            var track = carousel.querySelector('.evt2-track');
            var prev = carousel.querySelector('.evt2-arrow-prev');
            var next = carousel.querySelector('.evt2-arrow-next');
            if (!viewport || !track || !prev || !next) return;

            function step() {
                var item = track.querySelector('.evt2-card');
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
