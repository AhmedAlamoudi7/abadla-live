@extends('layouts.site')

@section('body_class', 'personalities-page')

@section('content')
    <section class="pers-hero container" data-animate="fade-up">
        <div class="pers-hero-frame">
            <h1 class="pers-hero-title">شخصيات إعتبارية</h1>
        </div>
        @if ($introHtml)
            <div class="pers-intro article-text">{!! $introHtml !!}</div>
        @endif
    </section>

    <section class="pers-list container" data-animate="fade-up">
        <div class="pers-list-frame">
            <div class="pers-grid">
                @forelse ($personalities as $p)
                    <article class="pers-card">
                        <div class="pers-card-text">
                            <h3 class="pers-card-name">
                                <i class="far fa-user" aria-hidden="true"></i>
                                <span>{{ $p->full_name }}</span>
                            </h3>
                            @if ($p->birth_gregorian || $p->birth_hijri)
                                <p class="pers-card-line">
                                    <i class="far fa-calendar" aria-hidden="true"></i>
                                    <span>
                                        @if ($p->birth_gregorian){{ $p->birth_gregorian }} م @endif
                                        @if ($p->birth_gregorian && $p->birth_hijri) <span class="pers-card-sep">|</span> @endif
                                        @if ($p->birth_hijri){{ $p->birth_hijri }} هـ @endif
                                    </span>
                                </p>
                            @endif
                            @if ($p->location)
                                <p class="pers-card-line">
                                    <i class="fas fa-location-dot" aria-hidden="true"></i>
                                    <span>{{ $p->location }}</span>
                                </p>
                            @endif
                            @if ($p->branch)
                                <p class="pers-card-line pers-card-branch">
                                    <i class="fas fa-bars" aria-hidden="true"></i>
                                    <span>فرع : {{ $p->branch->name }}</span>
                                </p>
                            @endif
                        </div>
                        <div class="pers-card-photo">
                            @if ($p->photo)
                                <img src="{{ \App\Support\Media::url($p->photo) }}" alt="{{ $p->full_name }}" loading="lazy" />
                            @else
                                <span class="pers-card-photo-placeholder" aria-hidden="true"></span>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="pers-empty">لا توجد بيانات بعد.</p>
                @endforelse
            </div>

            <div class="pers-pagination">{{ $personalities->links('pagination.np') }}</div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    :root {
        --pers-cream: #f3ecdf;
        --pers-cream-2: #ece1cd;
        --pers-tan: #d8c4a3;
        --pers-border: #c9b18a;
        --pers-brown: #8a6e4a;
        --pers-brown-dark: #6a5235;
        --pers-text: #4a3a25;
    }

    .personalities-page { background: #faf5ec; }

    .pers-hero { padding: 40px 0 12px; }
    .pers-hero-frame {
        position: relative;
        border: 1.5px solid var(--pers-border);
        border-radius: 18px;
        padding: 64px 24px;
        text-align: center;
        background: linear-gradient(180deg, #f7f0e2, #f1e8d6);
    }
    .pers-hero-title {
        font-size: clamp(30px, 4.2vw, 56px);
        margin: 0;
        color: var(--pers-brown-dark);
        letter-spacing: 1px;
        font-weight: 800;
    }
    .pers-intro {
        max-width: 800px;
        margin: 16px auto 0;
        text-align: center;
        color: var(--pers-text);
    }

    .pers-list { padding: 24px 0 48px; }
    .pers-list-frame {
        border: 1.5px solid var(--pers-border);
        border-radius: 18px;
        padding: clamp(20px, 3vw, 40px);
        background: linear-gradient(180deg, #f5ecdb, #efe3ce);
    }

    .pers-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: clamp(18px, 2.4vw, 32px);
    }
    @media (max-width: 768px) {
        .pers-grid { grid-template-columns: 1fr; }
    }

    .pers-card {
        display: grid;
        grid-template-columns: 1fr 160px;
        gap: 16px;
        align-items: stretch;
        padding: 14px;
        background: transparent;
        border-radius: 14px;
        min-height: 220px;
    }
    @media (max-width: 480px) {
        .pers-card { grid-template-columns: 1fr 120px; min-height: 180px; }
    }

    .pers-card-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 12px;
        text-align: right;
        padding: 4px 2px;
    }
    .pers-card-name {
        display: flex; align-items: center; gap: 8px;
        margin: 0;
        font-size: clamp(15px, 1.4vw, 18px);
        font-weight: 700;
        color: var(--pers-brown-dark);
        line-height: 1.4;
    }
    .pers-card-name i { color: var(--pers-brown); font-size: 14px; }
    .pers-card-line {
        margin: 0;
        display: flex; align-items: center; gap: 8px;
        font-size: 14px; color: var(--pers-text);
        line-height: 1.6;
    }
    .pers-card-line i {
        color: var(--pers-brown);
        font-size: 13px;
        width: 16px;
        text-align: center;
        flex-shrink: 0;
    }
    .pers-card-sep {
        color: var(--pers-brown);
        margin: 0 6px;
        opacity: .6;
    }
    .pers-card-branch { font-weight: 600; }

    .pers-card-photo {
        position: relative;
        background: var(--pers-tan);
        border-radius: 10px;
        overflow: hidden;
        min-height: 200px;
    }
    @media (max-width: 480px) { .pers-card-photo { min-height: 160px; } }
    .pers-card-photo img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }
    .pers-card-photo-placeholder {
        display: block; width: 100%; height: 100%;
        background: var(--pers-tan);
    }

    .pers-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px 0;
        color: var(--pers-text);
        opacity: .8;
    }

    .pers-pagination {
        margin-top: 32px;
        padding: 12px 0 4px;
        display: flex;
        justify-content: center;
    }
</style>
@endpush
