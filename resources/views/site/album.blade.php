@extends('layouts.site')

@section('content')
    <section class="container" style="padding:40px 0 24px;" data-animate="fade-up">
        <h1 class="gradient-text" style="text-align:center;">الألبوم</h1>
        @if ($introHtml)
            <div class="article-text" style="max-width:800px;margin:16px auto;text-align:center;">{!! $introHtml !!}</div>
        @endif
    </section>

    <section class="gallery-section">
        <div class="gallery-wrapper">
            <div class="gallery-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;padding:0 16px 48px;">
                @foreach ($items as $item)
                    <figure class="gallery-card" style="margin:0;">
                        @if ($item->image)
                            <img src="{{ \App\Support\Media::url($item->image) }}" alt="{{ $item->caption }}" style="width:100%;height:220px;object-fit:cover;border-radius:12px;" loading="lazy" />
                        @endif
                        @if ($item->caption)
                            <figcaption style="margin-top:8px;font-size:14px;">{{ $item->caption }}</figcaption>
                        @endif
                        @if ($item->category)
                            <span style="font-size:12px;opacity:.75;">{{ $item->category->name }}</span>
                        @endif
                    </figure>
                @endforeach
            </div>
        </div>
        <div class="container">{{ $items->links() }}</div>
    </section>
@endsection
