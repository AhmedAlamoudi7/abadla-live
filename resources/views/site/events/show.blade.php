@extends('layouts.site')

@php
    use App\Support\Media;
    $fallbackImg = asset('legacy/img/event1.jpg');
    $tileImg = function ($e) use ($fallbackImg) {
        return ($e && $e->cover_image) ? Media::url($e->cover_image, $fallbackImg) : $fallbackImg;
    };
    $shareUrl  = url()->current();
    $shareText = $event->title;
    $enc       = rawurlencode($shareUrl);
    $encText   = rawurlencode($shareText);
@endphp

@section('body_class', 'events-page event-show-page')

@section('content')
    <section class="event-show-hero" aria-hidden="true">
        @if ($event->cover_image)
            <div class="event-show-hero__bg" style="background-image:url('{{ Media::url($event->cover_image) }}');"></div>
        @endif
        <div class="event-show-hero__veil"></div>
    </section>

    <section class="event-show-layout container" data-animate="fade-up">
        <article class="event-show">
            <header class="event-show__head">
                <div class="event-show__meta-row">
                    @if ($event->starts_at)
                        <time class="event-show__date" datetime="{{ $event->starts_at->toIso8601String() }}">
                            <i class="far fa-calendar" aria-hidden="true"></i>
                            <span>{{ $event->starts_at->locale('ar')->translatedFormat('j F Y — H:i') }}</span>
                        </time>
                    @endif
                    <span class="event-show__chip">فعالية</span>
                </div>
                <h1 class="event-show__title">{{ $event->title }}</h1>
                @if ($event->location)
                    <p class="event-show__subtitle">
                        <i class="fas fa-location-dot" aria-hidden="true"></i>
                        <span>{{ $event->location }}</span>
                    </p>
                @endif
            </header>

            @if ($event->cover_image)
                <figure class="event-show__media">
                    <img
                        src="{{ Media::url($event->cover_image) }}"
                        alt="{{ $event->title }}"
                        loading="eager"
                        decoding="async"
                        width="1200"
                        height="675"
                    />
                </figure>
            @endif

            @if ($event->description)
                <p class="event-show__lead">{{ $event->description }}</p>
            @endif

            @if ($event->body)
                <div class="event-show__body article-text">
                    {!! $event->body !!}
                </div>
            @endif

            @if ($event->detail_url)
                <p class="event-show__extra">
                    <a href="{{ $event->detail_url }}" target="_blank" rel="noopener noreferrer">
                        <i class="fas fa-link" aria-hidden="true"></i>
                        <span>رابط إضافي للتفاصيل</span>
                    </a>
                </p>
            @endif

            <div class="event-show__share" role="group" aria-label="مشاركة الفعالية">
                <span class="event-show__share-label">شارك الفعالية</span>
                <div class="event-show__share-buttons">
                    <a class="share-btn share-btn--fb"
                       href="https://www.facebook.com/sharer/sharer.php?u={{ $enc }}"
                       target="_blank" rel="noopener" aria-label="مشاركة على فيسبوك">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a class="share-btn share-btn--x"
                       href="https://twitter.com/intent/tweet?url={{ $enc }}&text={{ $encText }}"
                       target="_blank" rel="noopener" aria-label="مشاركة على X">
                        <i class="fab fa-x-twitter" aria-hidden="true"></i>
                    </a>
                    <a class="share-btn share-btn--wa"
                       href="https://wa.me/?text={{ $encText }}%20{{ $enc }}"
                       target="_blank" rel="noopener" aria-label="مشاركة عبر واتساب">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    </a>
                    <a class="share-btn share-btn--tg"
                       href="https://t.me/share/url?url={{ $enc }}&text={{ $encText }}"
                       target="_blank" rel="noopener" aria-label="مشاركة عبر تيليجرام">
                        <i class="fab fa-telegram-plane" aria-hidden="true"></i>
                    </a>
                    <a class="share-btn share-btn--ln"
                       href="https://www.linkedin.com/sharing/share-offsite/?url={{ $enc }}"
                       target="_blank" rel="noopener" aria-label="مشاركة على لينكدإن">
                        <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                    <a class="share-btn share-btn--mail"
                       href="mailto:?subject={{ $encText }}&body={{ $enc }}"
                       aria-label="مشاركة عبر البريد">
                        <i class="far fa-envelope" aria-hidden="true"></i>
                    </a>
                    <button type="button" class="share-btn share-btn--copy" data-share-copy="{{ $shareUrl }}" aria-label="نسخ الرابط">
                        <i class="far fa-copy" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <footer class="event-show__footer">
                <a href="{{ route('events.index') }}" class="event-show__back">
                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    <span>العودة للفعاليات</span>
                </a>
            </footer>
        </article>

        <aside class="event-show__aside" data-animate="fade-up">
            <div class="event-latest">
                <header class="event-latest__head">
                    <span class="event-latest__accent" aria-hidden="true"></span>
                    <h2 class="event-latest__title">آخر الفعاليات</h2>
                </header>
                <ul class="event-latest__list">
                    @forelse ($latest as $item)
                        <li>
                            <a href="{{ route('events.show', $item->slug) }}" class="event-latest__row">
                                <span class="event-latest__thumb">
                                    <img src="{{ $tileImg($item) }}" alt="" loading="lazy" width="120" height="120" />
                                </span>
                                <span class="event-latest__meta">
                                    <span class="event-latest__row-title">{{ $item->title }}</span>
                                    @if ($item->starts_at)
                                        <span class="event-latest__row-date">
                                            <i class="far fa-calendar" aria-hidden="true"></i>
                                            {{ $item->starts_at->locale('ar')->translatedFormat('j F Y') }}
                                        </span>
                                    @endif
                                    @if ($item->location)
                                        <span class="event-latest__row-loc">
                                            <i class="fas fa-location-dot" aria-hidden="true"></i>
                                            {{ $item->location }}
                                        </span>
                                    @endif
                                </span>
                            </a>
                        </li>
                    @empty
                        <li class="event-latest__empty">لا توجد فعاليات أخرى حالياً.</li>
                    @endforelse
                </ul>
                <a href="{{ route('events.index') }}" class="event-latest__all">
                    <span>عرض كل الفعاليات</span>
                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                </a>
            </div>
        </aside>
    </section>
@endsection

@push('styles')
<style>
    .event-show-page { background:
        radial-gradient(1200px 600px at 100% -10%, rgba(139,115,85,.10), transparent 60%),
        radial-gradient(900px 500px at -10% 110%, rgba(139,115,85,.08), transparent 60%),
        linear-gradient(180deg, #f7f2ea 0%, #fbf7f1 100%);
    }

    .event-show-hero { position: relative; height: 260px; overflow: hidden; margin-bottom: -120px; }
    .event-show-hero__bg {
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        filter: blur(28px) saturate(1.1);
        transform: scale(1.1); opacity: .55;
    }
    .event-show-hero__veil {
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(247,242,234,.35) 0%, rgba(247,242,234,1) 90%);
    }

    .event-show-layout {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 32px;
        padding: 32px 0 64px;
        align-items: start;
    }
    @media (max-width: 992px) {
        .event-show-layout { grid-template-columns: 1fr; gap: 24px; }
    }

    .event-show {
        background: rgba(255,255,255,.85);
        -webkit-backdrop-filter: saturate(1.1) blur(8px);
        backdrop-filter: saturate(1.1) blur(8px);
        border: 1px solid rgba(139,115,85,.15);
        border-radius: 18px;
        box-shadow: 0 24px 60px -28px rgba(80,55,20,.25), 0 6px 20px -12px rgba(80,55,20,.15);
        padding: 28px clamp(16px, 3vw, 40px);
    }

    .event-show__head { margin-bottom: 20px; }
    .event-show__meta-row {
        display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
        margin-bottom: 14px;
    }
    .event-show__date { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #7a6a55; }
    .event-show__chip {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 999px;
        background: linear-gradient(135deg, #8b7355, #a68a6a);
        color: #fff;
        font-size: 12px; font-weight: 700;
    }
    .event-show__title {
        font-size: clamp(22px, 3vw, 34px);
        line-height: 1.35;
        margin: 0 0 10px;
        color: #3a2e1f;
    }
    .event-show__subtitle {
        display: inline-flex; align-items: center; gap: 6px;
        color: #5a4a35; font-size: 15px; margin: 4px 0 0;
    }

    .event-show__media { margin: 18px 0 22px; border-radius: 14px; overflow: hidden; box-shadow: 0 18px 40px -24px rgba(80,55,20,.35); }
    .event-show__media img { width: 100%; height: auto; display: block; }

    .event-show__lead { font-size: 17px; line-height: 1.85; color: #5a4a35; margin: 0 0 14px; }
    .event-show__body { font-size: 16px; line-height: 2; color: #3a2e1f; }
    .event-show__body p { margin: 0 0 14px; }

    .event-show__extra { margin: 16px 0 0; font-weight: 600; }
    .event-show__extra a {
        display: inline-flex; align-items: center; gap: 6px;
        color: #8b7355; text-decoration: none;
    }
    .event-show__extra a:hover { color: #3a2e1f; text-decoration: underline; }

    .event-show__share {
        display: flex; flex-wrap: wrap; gap: 12px; align-items: center;
        margin: 28px 0 8px;
        padding: 16px 18px;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(139,115,85,.08), rgba(139,115,85,.02));
        border: 1px dashed rgba(139,115,85,.35);
    }
    .event-show__share-label { font-weight: 700; color: #5a4a35; font-size: 14px; margin-inline-end: 4px; }
    .event-show__share-buttons { display: flex; flex-wrap: wrap; gap: 8px; }

    .share-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 40px; height: 40px;
        border-radius: 50%;
        background: #fff;
        color: #5a4a35;
        border: 1px solid rgba(139,115,85,.25);
        text-decoration: none;
        cursor: pointer;
        transition: transform .18s ease, background .18s ease, color .18s ease, box-shadow .18s ease;
        box-shadow: 0 4px 10px -6px rgba(80,55,20,.25);
    }
    .share-btn:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 10px 18px -8px rgba(80,55,20,.35); }
    .share-btn--fb:hover   { background: #1877f2; border-color: #1877f2; }
    .share-btn--x:hover    { background: #111; border-color: #111; }
    .share-btn--wa:hover   { background: #25d366; border-color: #25d366; }
    .share-btn--tg:hover   { background: #26a5e4; border-color: #26a5e4; }
    .share-btn--ln:hover   { background: #0a66c2; border-color: #0a66c2; }
    .share-btn--mail:hover { background: #8b7355; border-color: #8b7355; }
    .share-btn--copy:hover { background: #3a2e1f; border-color: #3a2e1f; }
    .share-btn.is-copied   { background: #25a244; border-color: #25a244; color: #fff; }

    .event-show__footer { margin-top: 24px; padding-top: 18px; border-top: 1px solid rgba(139,115,85,.18); }
    .event-show__back {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: 999px;
        background: #fff; color: #5a4a35;
        border: 1px solid rgba(139,115,85,.3);
        text-decoration: none; font-weight: 600;
        transition: background .2s ease, color .2s ease;
    }
    .event-show__back:hover { background: #8b7355; color: #fff; }

    .event-show__aside { position: sticky; top: 96px; }
    @media (max-width: 992px) { .event-show__aside { position: static; } }

    .event-latest {
        background: rgba(255,255,255,.9);
        border: 1px solid rgba(139,115,85,.15);
        border-radius: 16px;
        padding: 18px 16px;
        box-shadow: 0 18px 40px -28px rgba(80,55,20,.2);
    }
    .event-latest__head { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
    .event-latest__accent {
        display: inline-block; width: 4px; height: 22px; border-radius: 4px;
        background: linear-gradient(180deg, #8b7355, #a68a6a);
    }
    .event-latest__title { margin: 0; font-size: 18px; color: #3a2e1f; }
    .event-latest__list { list-style: none; padding: 0; margin: 0; display: grid; gap: 10px; }
    .event-latest__row {
        display: grid; grid-template-columns: 80px 1fr; gap: 12px; align-items: center;
        padding: 8px; border-radius: 12px;
        text-decoration: none; color: inherit;
        transition: background .2s ease, transform .2s ease;
    }
    .event-latest__row:hover { background: rgba(139,115,85,.08); transform: translateX(-2px); }
    .event-latest__thumb { display: block; width: 80px; height: 80px; border-radius: 10px; overflow: hidden; background: #eee; }
    .event-latest__thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .event-latest__meta { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
    .event-latest__row-title {
        font-size: 14px; font-weight: 700; color: #3a2e1f; line-height: 1.45;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .event-latest__row-date, .event-latest__row-loc {
        font-size: 12px; color: #8b7355;
        display: inline-flex; align-items: center; gap: 4px;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .event-latest__empty { padding: 10px; text-align: center; color: #7a6a55; font-size: 14px; }
    .event-latest__all {
        display: inline-flex; align-items: center; gap: 6px;
        margin-top: 12px; font-size: 14px; font-weight: 700;
        color: #8b7355; text-decoration: none;
    }
    .event-latest__all:hover { color: #3a2e1f; }
</style>
@endpush

@push('scripts')
<script>
(function () {
    document.querySelectorAll('[data-share-copy]').forEach(btn => {
        btn.addEventListener('click', async () => {
            const url = btn.getAttribute('data-share-copy');
            try {
                await navigator.clipboard.writeText(url);
            } catch (e) {
                const ta = document.createElement('textarea');
                ta.value = url; document.body.appendChild(ta);
                ta.select(); try { document.execCommand('copy'); } catch (_) {}
                document.body.removeChild(ta);
            }
            btn.classList.add('is-copied');
            const icon = btn.querySelector('i');
            const prev = icon ? icon.className : '';
            if (icon) icon.className = 'fas fa-check';
            setTimeout(() => {
                btn.classList.remove('is-copied');
                if (icon) icon.className = prev;
            }, 1400);
        });
    });
})();
</script>
@endpush
