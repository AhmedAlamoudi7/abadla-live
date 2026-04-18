@extends('layouts.site')

@section('content')
    <section class="container" style="padding:40px 0 24px;" data-animate="fade-up">
        <h1 class="gradient-text" style="text-align:center;">شخصيات إعتبارية</h1>
        @if ($introHtml)
            <div class="article-text" style="max-width:800px;margin:16px auto;text-align:center;">{!! $introHtml !!}</div>
        @endif
    </section>

    <section class="container" style="padding-bottom:48px;">
        <div class="news-grid">
            @forelse ($personalities as $p)
                <article class="news-card">
                    <div class="news-text">
                        <h3>{{ $p->full_name }}</h3>
                        <p>
                            @if ($p->branch)
                                {{ $p->branch->name }}
                            @endif
                            @if ($p->location)
                                — {{ $p->location }}
                            @endif
                        </p>
                        <p style="font-size:14px;opacity:.85;">
                            @if ($p->birth_gregorian)
                                {{ $p->birth_gregorian }}
                            @endif
                            @if ($p->birth_hijri)
                                ({{ $p->birth_hijri }} هـ)
                            @endif
                        </p>
                    </div>
                    <div class="news-image">
                        @if ($p->photo)
                            <img src="{{ \App\Support\Media::url($p->photo) }}" alt="" />
                        @else
                            <i class="fas fa-user-tie"></i>
                        @endif
                    </div>
                </article>
            @empty
                <p style="grid-column:1/-1;text-align:center;">لا توجد بيانات بعد.</p>
            @endforelse
        </div>
        <div style="padding:24px 0;">{{ $personalities->links() }}</div>
    </section>
@endsection
