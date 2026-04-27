@extends('layouts.site')

@php
    use App\Support\Media;
    $fallbackImg = asset('legacy/img/article.jpg');
@endphp

@section('body_class', 'articles-page')

@section('content')
    <section class="container" style="padding:40px 0 16px;" data-animate="fade-up">
        <h1 class="gradient-text" style="text-align:center;">مقالات</h1>
    </section>

    <section class="container" style="padding-bottom:48px;" data-animate="fade-up">
        <div class="articles-grid">
            @forelse ($articles as $article)
                <a href="{{ route('news.show', $article->slug) }}" class="article-card">
                    <div class="article-card-image">
                        <img
                            src="{{ $article->featured_image ? Media::url($article->featured_image, $fallbackImg) : $fallbackImg }}"
                            alt="{{ $article->title }}"
                            loading="lazy"
                            width="600"
                            height="380"
                        />
                    </div>
                    <div class="article-card-body">
                        @if ($article->published_at)
                            <span class="article-card-date">
                                {{ $article->published_at->locale('ar')->translatedFormat('j F Y') }}
                            </span>
                        @endif
                        <h3 class="article-card-title">{{ $article->title }}</h3>
                        @if ($article->excerpt)
                            <p class="article-card-excerpt">{{ $article->excerpt }}</p>
                        @endif
                        <span class="article-card-more">
                            قراءة المزيد
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        </span>
                    </div>
                </a>
            @empty
                <p style="grid-column:1/-1;text-align:center;padding:48px 0;">لا توجد مقالات منشورة بعد.</p>
            @endforelse
        </div>

        <div style="padding:24px 0;">{{ $articles->links('pagination.np') }}</div>
    </section>
@endsection

@push('styles')
    <style>
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }

        .article-card {
            display: flex;
            flex-direction: column;
            background: var(--cream-light, #faf8f5);
            border-radius: 16px;
            overflow: hidden;
            color: inherit;
            text-decoration: none;
            box-shadow: 0 6px 18px -12px rgba(80, 55, 20, .25);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .article-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 34px -18px rgba(80, 55, 20, .4);
        }

        .article-card-image {
            aspect-ratio: 16 / 10;
            overflow: hidden;
            background: #ddd;
        }

        .article-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .45s ease;
        }

        .article-card:hover .article-card-image img {
            transform: scale(1.04);
        }

        .article-card-body {
            padding: 18px 20px 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .article-card-date {
            font-size: 12px;
            color: var(--brown-mid, #8b7355);
            font-weight: 600;
        }

        .article-card-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--brown-dark, #563c2f);
            line-height: 1.4;
            margin: 0;
        }

        .article-card-excerpt {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article-card-more {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--brown-mid, #8b7355);
            font-weight: 700;
            font-size: 14px;
        }
    </style>
@endpush
