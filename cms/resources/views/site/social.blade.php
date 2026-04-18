@extends('layouts.site')

@php
    use App\Support\Media;
    $row1 = $categories->slice(0, 3);
    $row2 = $categories->slice(3);
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
            <a href="{{ route('social') }}" class="soc-pill {{ $activeCategorySlug ? '' : 'is-active' }}">
                <span>الكل</span>
            </a>
            @foreach ($row1 as $cat)
                    <a href="{{ route('social', ['category' => $cat->slug]) }}" class="soc-pill {{ $activeCategorySlug === $cat->slug ? 'is-active' : '' }}">
                        <span>{{ $cat->name }}</span>
                        @if ($cat->icon_image)
                            <i aria-hidden="true"><img src="{{ Media::url($cat->icon_image) }}" alt="" /></i>
                        @endif
                    </a>
            @endforeach
        </div>
        @if ($row2->isNotEmpty())
            <div class="soc-pills-row">
                @foreach ($row2 as $cat)
                    <a href="{{ route('social', ['category' => $cat->slug]) }}" class="soc-pill {{ $activeCategorySlug === $cat->slug ? 'is-active' : '' }}">
                        <span>{{ $cat->name }}</span>
                        @if ($cat->icon_image)
                            <i aria-hidden="true"><img src="{{ Media::url($cat->icon_image) }}" alt="" /></i>
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
                    <div class="news-image">
                        @if ($item->image)
                            <img src="{{ Media::url($item->image) }}" alt="" style="width:100%;height:100%;object-fit:cover;" loading="lazy" />
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
        .soc-pill.is-active {
            outline: 2px solid var(--accent-brown, #8b7355);
            outline-offset: 2px;
        }
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
        .soc-pill { transition: transform .2s ease, background .2s ease; }
        .soc-pill:active { transform: scale(.97); }
    </style>
@endpush

@push('scripts')
    <script>
    (function () {
        const resultsSel = '#soc-results';
        const pillSel = '.soc-categories a.soc-pill';

        async function swap(url, push = true) {
            const results = document.querySelector(resultsSel);
            if (!results) return;

            results.classList.add('is-leaving');
            await new Promise(r => setTimeout(r, 280));

            let html;
            try {
                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } });
                html = await res.text();
            } catch (e) {
                window.location.href = url;
                return;
            }

            const doc = new DOMParser().parseFromString(html, 'text/html');
            const nextResults = doc.querySelector(resultsSel);
            const nextPills = doc.querySelector('.soc-categories');
            if (!nextResults) { window.location.href = url; return; }

            results.replaceWith(nextResults);
            if (nextPills) {
                const currentPills = document.querySelector('.soc-categories');
                if (currentPills) currentPills.replaceWith(nextPills);
                bindPills();
                bindInPageLinks();
            }

            nextResults.classList.add('is-entering');
            requestAnimationFrame(() => {
                requestAnimationFrame(() => nextResults.classList.remove('is-entering'));
            });

            if (push) history.pushState({ socUrl: url }, '', url);
            window.scrollTo({ top: nextResults.offsetTop - 80, behavior: 'smooth' });
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
