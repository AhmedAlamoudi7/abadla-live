@extends('layouts.site')

@section('content')
    <section class="container" style="padding:40px 0 24px;" data-animate="fade-up">
        <h1 class="gradient-text" style="text-align:center;">إجتماعيات</h1>
        @if ($introHtml)
            <div class="article-text" style="max-width:800px;margin:16px auto;text-align:center;">{!! $introHtml !!}</div>
        @endif
    </section>

    <section class="container" style="padding-bottom:48px;">
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
                            <img src="{{ \App\Support\Media::url($item->image) }}" alt="" />
                        @else
                            <i class="fas fa-heart"></i>
                        @endif
                    </div>
                </article>
            @empty
                <p style="grid-column:1/-1;text-align:center;">لا توجد مناسبات منشورة بعد.</p>
            @endforelse
        </div>
        <div style="padding:24px 0;">{{ $occasions->links() }}</div>
    </section>
@endsection
