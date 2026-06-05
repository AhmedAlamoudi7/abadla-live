@extends('layouts.site')

@php
    use App\Support\Media;
    $fallbackImg = asset('legacy/img/banner.jpg');
    $coverUrl = $occasion->image ? Media::url($occasion->image) : null;
    $tileImg = function ($o) use ($fallbackImg) {
        return ($o && $o->image) ? Media::url($o->image, $fallbackImg) : $fallbackImg;
    };
    $shareUrl  = url()->current();
    $shareText = $occasion->title;
    $enc       = rawurlencode($shareUrl);
    $encText   = rawurlencode($shareText);
@endphp

@section('body_class', 'social-page soc-show-page')

@section('content')
    <section class="soc-show-hero" aria-hidden="true">
        @if ($coverUrl)
            <div class="soc-show-hero__bg" style="background-image:url('{{ $coverUrl }}');"></div>
        @endif
        <div class="soc-show-hero__veil"></div>
    </section>

    <section class="soc-show-layout container" data-animate="fade-up">
        <article class="soc-show">
            <header class="soc-show__head">
                <div class="soc-show__meta-row">
                    @if ($occasion->occurred_on)
                        <time class="soc-show__date" datetime="{{ $occasion->occurred_on->toDateString() }}">
                            <i class="far fa-calendar" aria-hidden="true"></i>
                            <span>{{ $occasion->occurred_on->locale('ar')->translatedFormat('j F Y') }}</span>
                        </time>
                    @endif
                    @if ($occasion->category)
                        <a class="soc-show__chip" href="{{ route('social', ['category' => $occasion->category->slug]) }}">
                            {{ $occasion->category->name }}
                        </a>
                    @endif
                </div>
                <h1 class="soc-show__title">{{ $occasion->title }}</h1>
            </header>

            @if ($coverUrl)
                <figure class="soc-show__media">
                    <img
                        src="{{ $coverUrl }}"
                        alt="{{ $occasion->title }}"
                        loading="eager"
                        decoding="async"
                        width="1200"
                        height="675"
                    />
                </figure>
            @endif

            @if ($occasion->excerpt)
                <p class="soc-show__lead">{{ $occasion->excerpt }}</p>
            @endif

            @if ($occasion->body)
                <div class="soc-show__body article-text">
                    {!! $occasion->body !!}
                </div>
            @endif

            @if (! empty($gallery))
                <section class="soc-gallery" aria-label="ألبوم صور المناسبة">
                    <h2 class="soc-gallery__title">
                        <span class="soc-gallery__accent" aria-hidden="true"></span>
                        ألبوم الصور
                        <span class="soc-gallery__count">({{ count($gallery) }})</span>
                    </h2>
                    <div class="soc-gallery__grid" id="socGalleryGrid">
                        @foreach ($gallery as $i => $img)
                            <button
                                type="button"
                                class="soc-gallery__item"
                                data-soc-index="{{ $i }}"
                                aria-label="عرض الصورة {{ $i + 1 }}"
                            >
                                <img src="{{ $img }}" alt="{{ $occasion->title }} — صورة {{ $i + 1 }}" loading="lazy" decoding="async" />
                            </button>
                        @endforeach
                    </div>
                </section>
            @endif

            <div class="soc-show__share" role="group" aria-label="مشاركة المناسبة">
                <span class="soc-show__share-label">شارك المناسبة</span>
                <div class="soc-show__share-buttons">
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

            <footer class="soc-show__footer">
                <a href="{{ route('social') }}" class="soc-show__back">
                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    <span>العودة للإجتماعيات</span>
                </a>
            </footer>
        </article>

        <aside class="soc-show__aside" data-animate="fade-up">
            <div class="soc-latest">
                <header class="soc-latest__head">
                    <span class="soc-latest__accent" aria-hidden="true"></span>
                    <h2 class="soc-latest__title">مناسبات أخرى</h2>
                </header>
                <ul class="soc-latest__list">
                    @forelse ($latest as $item)
                        <li>
                            <a href="{{ route('social.show', $item->slug) }}" class="soc-latest__row">
                                <span class="soc-latest__thumb">
                                    <img src="{{ $tileImg($item) }}" alt="" loading="lazy" width="120" height="120" />
                                </span>
                                <span class="soc-latest__meta">
                                    <span class="soc-latest__row-title">{{ $item->title }}</span>
                                    @if ($item->occurred_on)
                                        <span class="soc-latest__row-date">
                                            <i class="far fa-calendar" aria-hidden="true"></i>
                                            {{ $item->occurred_on->locale('ar')->translatedFormat('j F Y') }}
                                        </span>
                                    @endif
                                    @if ($item->category)
                                        <span class="soc-latest__row-loc">
                                            <i class="fas fa-tag" aria-hidden="true"></i>
                                            {{ $item->category->name }}
                                        </span>
                                    @endif
                                </span>
                            </a>
                        </li>
                    @empty
                        <li class="soc-latest__empty">لا توجد مناسبات أخرى حالياً.</li>
                    @endforelse
                </ul>
                <a href="{{ route('social') }}" class="soc-latest__all">
                    <span>عرض كل الإجتماعيات</span>
                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                </a>
            </div>
        </aside>
    </section>

    @if (! empty($gallery))
        <div class="soc-lightbox" id="socLightbox" aria-hidden="true">
            <button type="button" class="soc-lightbox__close" aria-label="إغلاق">&times;</button>
            <button type="button" class="soc-lightbox__nav soc-lightbox__prev" aria-label="السابق">&#8250;</button>
            <img class="soc-lightbox__img" id="socLightboxImg" alt="" />
            <button type="button" class="soc-lightbox__nav soc-lightbox__next" aria-label="التالي">&#8249;</button>
            <div class="soc-lightbox__counter" id="socLightboxCounter"></div>
        </div>
    @endif
@endsection

@push('styles')
<style>
    body.soc-show-page { background:
        radial-gradient(1200px 600px at 100% -10%, rgba(139,115,85,.10), transparent 60%),
        radial-gradient(900px 500px at -10% 110%, rgba(139,115,85,.08), transparent 60%),
        linear-gradient(180deg, #f7f2ea 0%, #fbf7f1 100%);
    }

    .soc-show-hero { position: relative; height: 260px; overflow: hidden; margin-bottom: -120px; }
    .soc-show-hero__bg {
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        filter: blur(28px) saturate(1.1);
        transform: scale(1.1); opacity: .55;
    }
    .soc-show-hero__veil {
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(247,242,234,.35) 0%, rgba(247,242,234,1) 90%);
    }

    .soc-show-layout {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 32px;
        padding: 32px 0 64px;
        align-items: start;
    }
    @media (max-width: 992px) {
        .soc-show-layout { grid-template-columns: 1fr; gap: 24px; }
    }

    .soc-show {
        background: rgba(255,255,255,.85);
        -webkit-backdrop-filter: saturate(1.1) blur(8px);
        backdrop-filter: saturate(1.1) blur(8px);
        border: 1px solid rgba(139,115,85,.15);
        border-radius: 18px;
        box-shadow: 0 24px 60px -28px rgba(80,55,20,.25), 0 6px 20px -12px rgba(80,55,20,.15);
        padding: 28px clamp(16px, 3vw, 40px);
    }

    .soc-show__head { margin-bottom: 20px; }
    .soc-show__meta-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 14px; }
    .soc-show__date { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #7a6a55; }
    .soc-show__chip {
        display: inline-block; padding: 4px 12px; border-radius: 999px;
        background: linear-gradient(135deg, #8b7355, #a68a6a);
        color: #fff; font-size: 12px; font-weight: 700; text-decoration: none;
        transition: filter .2s ease;
    }
    .soc-show__chip:hover { filter: brightness(1.08); }
    .soc-show__title { font-size: clamp(22px, 3vw, 34px); line-height: 1.35; margin: 0; color: #3a2e1f; }

    .soc-show__media { margin: 18px 0 22px; border-radius: 14px; overflow: hidden; box-shadow: 0 18px 40px -24px rgba(80,55,20,.35); }
    .soc-show__media img { width: 100%; height: auto; display: block; }

    .soc-show__lead { font-size: 17px; line-height: 1.85; color: #5a4a35; margin: 0 0 14px; }
    .soc-show__body { font-size: 16px; line-height: 2; color: #3a2e1f; }
    .soc-show__body p { margin: 0 0 14px; }

    /* Gallery */
    .soc-gallery { margin: 26px 0 8px; }
    .soc-gallery__title {
        display: flex; align-items: center; gap: 10px;
        font-size: 19px; color: #3a2e1f; margin: 0 0 16px;
    }
    .soc-gallery__accent { display: inline-block; width: 4px; height: 22px; border-radius: 4px; background: linear-gradient(180deg, #8b7355, #a68a6a); }
    .soc-gallery__count { color: #8b7355; font-size: 15px; font-weight: 600; }
    .soc-gallery__grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
    }
    .soc-gallery__item {
        position: relative; padding: 0; border: 0; cursor: pointer;
        aspect-ratio: 1 / 1; border-radius: 12px; overflow: hidden; background: #efe7db;
        box-shadow: 0 8px 20px -14px rgba(80,55,20,.35);
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .soc-gallery__item:hover { transform: translateY(-3px); box-shadow: 0 16px 30px -16px rgba(80,55,20,.45); }
    .soc-gallery__item img { width: 100%; height: 100%; object-fit: cover; display: block; }

    /* Lightbox */
    .soc-lightbox {
        position: fixed; inset: 0; z-index: 9999;
        display: none; align-items: center; justify-content: center;
        background: rgba(20, 14, 8, .92);
        padding: 24px;
    }
    .soc-lightbox.is-open { display: flex; }
    .soc-lightbox__img { max-width: 90vw; max-height: 84vh; border-radius: 10px; box-shadow: 0 30px 80px rgba(0,0,0,.6); }
    .soc-lightbox__close {
        position: absolute; top: 18px; inset-inline-end: 22px;
        width: 46px; height: 46px; border-radius: 50%; border: 0; cursor: pointer;
        background: rgba(255,255,255,.12); color: #fff; font-size: 28px; line-height: 1;
    }
    .soc-lightbox__close:hover { background: rgba(255,255,255,.25); }
    .soc-lightbox__nav {
        position: absolute; top: 50%; transform: translateY(-50%);
        width: 52px; height: 52px; border-radius: 50%; border: 0; cursor: pointer;
        background: rgba(255,255,255,.12); color: #fff; font-size: 30px; line-height: 1;
    }
    .soc-lightbox__nav:hover { background: rgba(255,255,255,.25); }
    .soc-lightbox__prev { inset-inline-end: 18px; }
    .soc-lightbox__next { inset-inline-start: 18px; }
    .soc-lightbox__counter { position: absolute; bottom: 20px; inset-inline: 0; text-align: center; color: #fff; font-size: 14px; opacity: .85; }

    .soc-show__share {
        display: flex; flex-wrap: wrap; gap: 12px; align-items: center;
        margin: 28px 0 8px; padding: 16px 18px; border-radius: 14px;
        background: linear-gradient(135deg, rgba(139,115,85,.08), rgba(139,115,85,.02));
        border: 1px dashed rgba(139,115,85,.35);
    }
    .soc-show__share-label { font-weight: 700; color: #5a4a35; font-size: 14px; margin-inline-end: 4px; }
    .soc-show__share-buttons { display: flex; flex-wrap: wrap; gap: 8px; }

    .share-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 40px; height: 40px; border-radius: 50%;
        background: #fff; color: #5a4a35; border: 1px solid rgba(139,115,85,.25);
        text-decoration: none; cursor: pointer;
        transition: transform .18s ease, background .18s ease, color .18s ease, box-shadow .18s ease;
        box-shadow: 0 4px 10px -6px rgba(80,55,20,.25);
    }
    .share-btn:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 10px 18px -8px rgba(80,55,20,.35); }
    .share-btn--fb:hover   { background: #1877f2; border-color: #1877f2; }
    .share-btn--x:hover    { background: #111; border-color: #111; }
    .share-btn--wa:hover   { background: #25d366; border-color: #25d366; }
    .share-btn--tg:hover   { background: #26a5e4; border-color: #26a5e4; }
    .share-btn--mail:hover { background: #8b7355; border-color: #8b7355; }
    .share-btn--copy:hover { background: #3a2e1f; border-color: #3a2e1f; }
    .share-btn.is-copied   { background: #25a244; border-color: #25a244; color: #fff; }

    .soc-show__footer { margin-top: 24px; padding-top: 18px; border-top: 1px solid rgba(139,115,85,.18); }
    .soc-show__back {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: 999px;
        background: #fff; color: #5a4a35; border: 1px solid rgba(139,115,85,.3);
        text-decoration: none; font-weight: 600;
        transition: background .2s ease, color .2s ease;
    }
    .soc-show__back:hover { background: #8b7355; color: #fff; }

    .soc-show__aside { position: sticky; top: 96px; }
    @media (max-width: 992px) { .soc-show__aside { position: static; } }

    .soc-latest {
        background: rgba(255,255,255,.9); border: 1px solid rgba(139,115,85,.15);
        border-radius: 16px; padding: 18px 16px; box-shadow: 0 18px 40px -28px rgba(80,55,20,.2);
    }
    .soc-latest__head { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
    .soc-latest__accent { display: inline-block; width: 4px; height: 22px; border-radius: 4px; background: linear-gradient(180deg, #8b7355, #a68a6a); }
    .soc-latest__title { margin: 0; font-size: 18px; color: #3a2e1f; }
    .soc-latest__list { list-style: none; padding: 0; margin: 0; display: grid; gap: 10px; }
    .soc-latest__row {
        display: grid; grid-template-columns: 80px 1fr; gap: 12px; align-items: center;
        padding: 8px; border-radius: 12px; text-decoration: none; color: inherit;
        transition: background .2s ease, transform .2s ease;
    }
    .soc-latest__row:hover { background: rgba(139,115,85,.08); transform: translateX(-2px); }
    .soc-latest__thumb { display: block; width: 80px; height: 80px; border-radius: 10px; overflow: hidden; background: #eee; }
    .soc-latest__thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .soc-latest__meta { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
    .soc-latest__row-title {
        font-size: 14px; font-weight: 700; color: #3a2e1f; line-height: 1.45;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .soc-latest__row-date, .soc-latest__row-loc {
        font-size: 12px; color: #8b7355; display: inline-flex; align-items: center; gap: 4px;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .soc-latest__empty { padding: 10px; text-align: center; color: #7a6a55; font-size: 14px; }
    .soc-latest__all {
        display: inline-flex; align-items: center; gap: 6px;
        margin-top: 12px; font-size: 14px; font-weight: 700; color: #8b7355; text-decoration: none;
    }
    .soc-latest__all:hover { color: #3a2e1f; }
</style>
@endpush

@push('scripts')
<script>
(function () {
    // Share: copy link
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

    // Gallery lightbox
    const images = @json($gallery ?? []);
    const grid = document.getElementById('socGalleryGrid');
    const box = document.getElementById('socLightbox');
    if (grid && box && images.length) {
        const imgEl = document.getElementById('socLightboxImg');
        const counter = document.getElementById('socLightboxCounter');
        let current = 0;

        function render() {
            imgEl.src = images[current];
            imgEl.alt = 'صورة ' + (current + 1);
            if (counter) counter.textContent = (current + 1) + ' / ' + images.length;
        }
        function open(i) { current = i; render(); box.classList.add('is-open'); box.setAttribute('aria-hidden', 'false'); }
        function close() { box.classList.remove('is-open'); box.setAttribute('aria-hidden', 'true'); imgEl.src = ''; }
        function move(step) { current = (current + step + images.length) % images.length; render(); }

        grid.querySelectorAll('.soc-gallery__item').forEach(btn => {
            btn.addEventListener('click', () => open(parseInt(btn.dataset.socIndex, 10) || 0));
        });
        box.querySelector('.soc-lightbox__close').addEventListener('click', close);
        box.querySelector('.soc-lightbox__prev').addEventListener('click', () => move(-1));
        box.querySelector('.soc-lightbox__next').addEventListener('click', () => move(1));
        box.addEventListener('click', (e) => { if (e.target === box) close(); });
        document.addEventListener('keydown', (e) => {
            if (!box.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            else if (e.key === 'ArrowLeft') move(1);
            else if (e.key === 'ArrowRight') move(-1);
        });
    }
})();
</script>
@endpush
