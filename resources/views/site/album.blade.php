@extends('layouts.site')

@section('body_class', 'album-page')

@section('content')
    <section class="container" style="padding:40px 0 16px;" data-animate="fade-up">
        <h1 class="gradient-text" style="text-align:center;">الألبوم</h1>
        @if ($introHtml)
            <div class="article-text" style="max-width:800px;margin:16px auto;text-align:center;">{!! $introHtml !!}</div>
        @endif
    </section>

    @if ($categories->isNotEmpty())
        <section class="container" style="padding-bottom:16px;" data-animate="fade-up">
            <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;">
                <a href="{{ route('album') }}" class="album-cat-pill {{ $activeCategorySlug ? '' : 'is-active' }}">الكل</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('album', ['category' => $cat->slug]) }}" class="album-cat-pill {{ $activeCategorySlug === $cat->slug ? 'is-active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </section>
    @endif

    <section class="gallery-section">
        <div class="gallery-wrapper">
            <div class="gallery-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;padding:0 16px 24px;">
                @forelse ($items as $item)
                    @php($imgUrl = $item->image ? \App\Support\Media::url($item->image) : null)
                    <figure
                        class="gallery-card {{ $imgUrl ? 'is-clickable' : '' }}"
                        style="margin:0;"
                        @if ($imgUrl)
                            role="button"
                            tabindex="0"
                            data-album-item
                            data-image="{{ $imgUrl }}"
                            data-caption="{{ $item->caption }}"
                            data-category="{{ $item->category?->name }}"
                        @endif
                    >
                        @if ($imgUrl)
                            <img src="{{ $imgUrl }}" alt="{{ $item->caption }}" style="width:100%;height:220px;object-fit:cover;border-radius:12px;" loading="lazy" width="400" height="300" />
                        @endif
                        @if ($item->caption)
                            <figcaption style="margin-top:8px;font-size:14px;">{{ $item->caption }}</figcaption>
                        @endif
                        @if ($item->category)
                            <span style="font-size:12px;opacity:.75;">{{ $item->category->name }}</span>
                        @endif
                    </figure>
                @empty
                    <p style="grid-column:1/-1;text-align:center;">لا توجد صور{{ $activeCategorySlug ? ' في هذا التصنيف' : '' }} بعد.</p>
                @endforelse
            </div>
        </div>
        <div class="container" style="padding-bottom:48px;">{{ $items->links('pagination.np') }}</div>
    </section>

    <div class="album-modal" id="albumModal" role="dialog" aria-modal="true" aria-labelledby="albumModalCaption" hidden>
        <button type="button" class="album-modal-close" aria-label="إغلاق" data-album-close>
            <i class="fas fa-times" aria-hidden="true"></i>
        </button>
        <div class="album-modal-backdrop" data-album-close></div>
        <div class="album-modal-dialog" role="document">
            <div class="album-modal-media">
                <img class="album-modal-img" id="albumModalImg" alt="" />
            </div>
            <div class="album-modal-body">
                <span class="album-modal-cat" id="albumModalCat" hidden></span>
                <p class="album-modal-caption" id="albumModalCaption"></p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .album-cat-pill {
            padding: 8px 16px;
            border-radius: 999px;
            border: 1px solid var(--brown-pale, #ddd);
            background: var(--cream-light, #faf8f5);
            color: var(--brown-dark, #333);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .album-cat-pill:hover { background: var(--cream, #f5f0ea); }
        .album-cat-pill.is-active {
            outline: 2px solid var(--accent-brown, #8b7355);
            outline-offset: 2px;
        }

        .gallery-card.is-clickable {
            cursor: zoom-in;
            transition: transform .25s ease, box-shadow .25s ease;
            border-radius: 12px;
        }
        .gallery-card.is-clickable:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 28px -16px rgba(80, 55, 20, .35);
        }
        .gallery-card.is-clickable:focus-visible {
            outline: 2px solid var(--accent-brown, #8b7355);
            outline-offset: 3px;
        }

        .album-modal {
            position: fixed;
            inset: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .22s ease;
        }
        .album-modal[hidden] { display: none !important; }
        .album-modal.is-open {
            opacity: 1;
            pointer-events: auto;
        }
        .album-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(20, 14, 10, .82);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        .album-modal-dialog {
            position: relative;
            background: var(--cream-light, #faf8f5);
            border-radius: 16px;
            max-width: min(960px, 96vw);
            max-height: 92vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 30px 60px -20px rgba(0, 0, 0, .5);
            transform: scale(.96);
            transition: transform .25s cubic-bezier(.16, 1, .3, 1);
        }
        .album-modal.is-open .album-modal-dialog { transform: scale(1); }
        .album-modal-media {
            background: #1a120c;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 280px;
            max-height: 70vh;
            overflow: hidden;
        }
        .album-modal-img {
            display: block;
            max-width: 100%;
            max-height: 70vh;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        .album-modal-body {
            padding: 18px 22px 22px;
            text-align: center;
        }
        .album-modal-cat {
            display: inline-block;
            margin-bottom: 8px;
            padding: 4px 12px;
            border-radius: 999px;
            background: rgba(139, 115, 85, .12);
            color: var(--brown-dark, #563c2f);
            font-size: 12px;
            font-weight: 600;
        }
        .album-modal-caption {
            margin: 0;
            font-size: 16px;
            line-height: 1.7;
            color: var(--brown-dark, #333);
        }
        .album-modal-close {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 2;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 0;
            background: rgba(255, 255, 255, .92);
            color: #333;
            font-size: 18px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 16px -8px rgba(0, 0, 0, .5);
            transition: transform .2s ease, background .2s ease;
        }
        .album-modal-close:hover {
            background: #fff;
            transform: rotate(90deg);
        }
        @media (max-width: 600px) {
            .album-modal { padding: 12px; }
            .album-modal-media { max-height: 60vh; }
            .album-modal-img { max-height: 60vh; }
            .album-modal-body { padding: 14px 16px 18px; }
        }
    </style>
@endpush

@push('scripts')
    <script>
    (function () {
        const modal = document.getElementById('albumModal');
        if (!modal) return;
        const imgEl = document.getElementById('albumModalImg');
        const capEl = document.getElementById('albumModalCaption');
        const catEl = document.getElementById('albumModalCat');
        let lastFocused = null;

        function open(item) {
            const src = item.dataset.image;
            if (!src) return;
            const caption = item.dataset.caption || '';
            const category = item.dataset.category || '';

            imgEl.src = src;
            imgEl.alt = caption;
            capEl.textContent = caption;
            if (category) {
                catEl.textContent = category;
                catEl.hidden = false;
            } else {
                catEl.hidden = true;
            }

            lastFocused = document.activeElement;
            modal.hidden = false;
            requestAnimationFrame(() => modal.classList.add('is-open'));
            document.body.style.overflow = 'hidden';
            modal.querySelector('.album-modal-close').focus();
        }

        function close() {
            modal.classList.remove('is-open');
            document.body.style.overflow = '';
            setTimeout(() => {
                modal.hidden = true;
                imgEl.src = '';
            }, 240);
            if (lastFocused && typeof lastFocused.focus === 'function') {
                lastFocused.focus();
            }
        }

        document.addEventListener('click', (e) => {
            const card = e.target.closest('[data-album-item]');
            if (card) {
                e.preventDefault();
                open(card);
                return;
            }
            if (e.target.closest('[data-album-close]')) {
                close();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (modal.hidden) return;
            if (e.key === 'Escape') close();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Enter' && e.key !== ' ') return;
            const card = e.target.closest('[data-album-item]');
            if (card) {
                e.preventDefault();
                open(card);
            }
        });
    })();
    </script>
@endpush
