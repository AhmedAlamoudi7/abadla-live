@extends('layouts.site')

@php
    use App\Support\Media;
    $row1 = $categories->slice(0, 4);
    $row2 = $categories->slice(4);
    $iconBySlug = [
        'engagement' => 'legacy/img/ring.svg',
        'wedding'    => 'legacy/img/married.svg',
        'birth'      => 'legacy/img/cake.svg',
        'graduation' => 'legacy/img/Icon (4).svg',
        'travel'     => 'legacy/img/elements (1).svg',
        'death'      => 'legacy/img/elements (2).svg',
        'martyrs'    => 'legacy/img/elements (3).svg',
    ];
    $pillIcon = function ($cat) use ($iconBySlug) {
        if ($cat->icon_image) {
            return Media::url($cat->icon_image);
        }
        return isset($iconBySlug[$cat->slug]) ? asset($iconBySlug[$cat->slug]) : null;
    };
@endphp

@section('body_class', 'social-page')

@section('content')
    <section class="soc-hero container" data-animate="fade-up">
        <div class="soc-hero-frame">
            <div class="soc-hero-media">
                <img
                    class="soc-hero-img"
                    src="{{ $heroImageUrl }}"
                    alt=""
                    width="1200"
                    height="520"
                    loading="eager"
                />
                <div class="soc-hero-caption">
                    <h1 class="soc-hero-title">{{ $heroTitle }}</h1>
                </div>
            </div>
        </div>
    </section>

    @if ($introHtml)
        <section class="container" style="padding:16px 0 0;" data-animate="fade-up">
            <div class="article-text" style="max-width:800px;margin:0 auto;text-align:center;">{!! $introHtml !!}</div>
        </section>
    @endif

    <section class="soc-categories container" data-animate="fade-up">
        <div class="soc-pills-row">
            <a href="{{ route('social') }}" class="soc-pill soc-pill--all {{ $activeCategorySlug ? '' : 'is-active' }}">
                <span>الكل</span>
                <i aria-hidden="true" class="soc-pill-ico soc-pill-ico--all">
                    <i class="fas fa-border-all"></i>
                </i>
            </a>
            @foreach ($row1 as $cat)
                @php($icoUrl = $pillIcon($cat))
                <a href="{{ route('social', ['category' => $cat->slug]) }}" class="soc-pill {{ $activeCategorySlug === $cat->slug ? 'is-active' : '' }}">
                    <span>{{ $cat->name }}</span>
                    @if ($icoUrl)
                        <i aria-hidden="true" class="soc-pill-ico"><img src="{{ $icoUrl }}" alt="" /></i>
                    @endif
                </a>
            @endforeach
        </div>
        @if ($row2->isNotEmpty())
            <div class="soc-pills-row">
                @foreach ($row2 as $cat)
                    @php($icoUrl = $pillIcon($cat))
                    <a href="{{ route('social', ['category' => $cat->slug]) }}" class="soc-pill {{ $activeCategorySlug === $cat->slug ? 'is-active' : '' }}">
                        <span>{{ $cat->name }}</span>
                        @if ($icoUrl)
                            <i aria-hidden="true" class="soc-pill-ico"><img src="{{ $icoUrl }}" alt="" /></i>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <section class="container soc-results" id="soc-results" style="padding-bottom:48px;" data-animate="fade-up">
        <div class="news-grid">
            @forelse ($occasions as $item)
                <article class="news-card social-card">
                    <div class="news-text">
                        <span class="news-date">{{ optional($item->occurred_on)->locale('ar')->translatedFormat('j F Y') }}</span>
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->excerpt ?? '' }}</p>
                        @if ($item->category)
                            <span class="badge" style="display:inline-block;margin-top:8px;padding:4px 10px;border-radius:999px;background:#f0f0f0;font-size:12px;">{{ $item->category->name }}</span>
                        @endif
                    </div>
                    <div class="news-image {{ $item->image ? 'news-image--has-img' : '' }}">
                        @if ($item->image)
                            <img src="{{ Media::url($item->image) }}" alt="" loading="lazy" decoding="async" />
                        @else
                            <i class="fas fa-heart"></i>
                        @endif
                    </div>
                </article>
            @empty
                <p style="grid-column:1/-1;text-align:center;">لا توجد مناسبات منشورة{{ $activeCategorySlug ? ' في هذا التصنيف' : '' }} بعد.</p>
            @endforelse
        </div>
        <div style="padding:24px 0;">{{ $occasions->links('pagination.np') }}</div>
    </section>
@endsection

@push('styles')
    <style>
        .social-card .news-image.news-image--has-img {
            background: #f4ece1;
            height: auto;
            min-height: 180px;
            aspect-ratio: 16 / 10;
            padding: 0;
            overflow: hidden;
        }
        .social-card .news-image.news-image--has-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
        @media (max-width: 768px) {
            .social-card .news-image.news-image--has-img {
                aspect-ratio: 16 / 9;
                min-height: 220px;
            }
        }

        .soc-pill {
            transition: transform .2s ease, background .2s ease, box-shadow .2s ease, border-color .2s ease, color .2s ease;
        }
        .soc-pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px -14px rgba(80,55,20,.35);
        }
        .soc-pill:active { transform: scale(.97); }
        .soc-pill.is-active {
            background: linear-gradient(135deg, rgba(139,115,85,.14), rgba(139,115,85,.04));
            border-color: var(--accent-brown, #8b7355) !important;
            outline: 2px solid var(--accent-brown, #8b7355);
            outline-offset: 2px;
            box-shadow: 0 14px 28px -16px rgba(80,55,20,.45);
        }
        .soc-pill .soc-pill-ico {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(139,115,85,.08);
            transition: background .2s ease, transform .2s ease;
        }
        .soc-pill .soc-pill-ico img {
            width: 18px;
            height: 18px;
            object-fit: contain;
            display: block;
        }
        .soc-pill .soc-pill-ico--all .fas,
        .soc-pill .soc-pill-ico .fas { color: #8b7355; font-size: 15px; }
        .soc-pill:hover .soc-pill-ico { background: rgba(139,115,85,.18); transform: rotate(-6deg); }
        .soc-pill.is-active .soc-pill-ico {
            background: linear-gradient(135deg, #8b7355, #a68a6a);
        }
        .soc-pill.is-active .soc-pill-ico img { filter: brightness(0) invert(1); }
        .soc-pill.is-active .soc-pill-ico .fas { color: #fff; }

        .soc-results {
            transition: opacity .28s ease, transform .28s ease;
            will-change: opacity, transform;
        }
        .soc-results.is-leaving {
            opacity: 0;
            transform: translateY(12px);
            pointer-events: none;
        }
        .soc-results.is-entering {
            opacity: 0;
            transform: translateY(12px);
        }
    </style>
@endpush

@push('scripts')
    <script>
    (function () {
        const resultsSel = '#soc-results';
        const pillSel = '.soc-categories a.soc-pill';

        async function swap(url, push = true) {
            const results = document.querySelector(resultsSel);
            if (!results) { window.location.href = url; return; }

            results.classList.add('is-leaving');
            await new Promise(r => setTimeout(r, 220));

            let html;
            try {
                const res = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                    credentials: 'same-origin',
                });
                if (!res.ok) throw new Error('bad status ' + res.status);
                html = await res.text();
            } catch (e) {
                window.location.href = url;
                return;
            }

            const doc = new DOMParser().parseFromString(html, 'text/html');
            const nextResults = doc.querySelector(resultsSel);
            const nextPills = doc.querySelector('.soc-categories');
            if (!nextResults) { window.location.href = url; return; }

            nextResults.classList.remove('is-leaving', 'is-entering');
            nextResults.classList.add('animated');

            results.replaceWith(nextResults);

            if (nextPills) {
                nextPills.classList.add('animated');
                const currentPills = document.querySelector('.soc-categories');
                if (currentPills) currentPills.replaceWith(nextPills);
            }
            bindPills();
            bindInPageLinks();

            nextResults.style.opacity = '0';
            nextResults.style.transform = 'translateY(10px)';
            requestAnimationFrame(() => {
                nextResults.style.transition = 'opacity .28s ease, transform .28s ease';
                nextResults.style.opacity = '1';
                nextResults.style.transform = 'translateY(0)';
            });

            if (push) history.pushState({ socUrl: url }, '', url);
            try { window.scrollTo({ top: Math.max(0, nextResults.getBoundingClientRect().top + window.scrollY - 80), behavior: 'smooth' }); } catch (_) {}
        }

        function bindPills() {
            document.querySelectorAll(pillSel).forEach(a => {
                if (a.dataset.socBound) return;
                a.dataset.socBound = '1';
                a.addEventListener('click', (e) => {
                    if (e.metaKey || e.ctrlKey || e.shiftKey || e.button === 1) return;
                    e.preventDefault();
                    swap(a.href);
                });
            });
        }

        function bindInPageLinks() {
            document.querySelectorAll(resultsSel + ' .np-pagination a').forEach(a => {
                if (a.dataset.socBound) return;
                a.dataset.socBound = '1';
                a.addEventListener('click', (e) => {
                    if (e.metaKey || e.ctrlKey || e.shiftKey || e.button === 1) return;
                    e.preventDefault();
                    swap(a.href);
                });
            });
        }

        window.addEventListener('popstate', () => swap(window.location.href, false));

        bindPills();
        bindInPageLinks();
    })();
    </script>
@endpush
