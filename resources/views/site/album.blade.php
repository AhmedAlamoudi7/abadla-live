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
                    <figure class="gallery-card" style="margin:0;">
                        @if ($item->image)
                            <img src="{{ \App\Support\Media::url($item->image) }}" alt="{{ $item->caption }}" style="width:100%;height:220px;object-fit:cover;border-radius:12px;" loading="lazy" width="400" height="300" />
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
    </style>
@endpush
