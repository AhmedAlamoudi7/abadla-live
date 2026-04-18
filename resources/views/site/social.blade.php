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

    <section class="container" style="padding-bottom:48px;" data-animate="fade-up">
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
    </style>
@endpush
