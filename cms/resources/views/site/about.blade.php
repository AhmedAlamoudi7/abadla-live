@extends('layouts.site')

@section('body_class', 'about-page')

@section('content')
    <section class="abt-title-section container" data-animate="fade-up">
        <h1 class="abt-main-title">{{ $aboutTitle }}</h1>
        @if ($aboutLead)
            <p class="abt-subtitle">{{ $aboutLead }}</p>
        @endif
        <div class="abt-title-rule" aria-hidden="true"></div>
    </section>

    <section class="abt-text-section container" data-animate="fade-up">
        @if ($aboutBodyHtml)
            <div class="about-dynamic">{!! $aboutBodyHtml !!}</div>
        @else
            <p>لم يُضف نص بعد. يمكن تعديله من إعدادات الموقع أو من لوحة التحكم.</p>
        @endif
    </section>

    <section class="abt-branches container" data-animate="fade-up">
        <div class="abt-branches-box">
            <div class="abt-section-heading">
                <span class="abt-section-heading-line" aria-hidden="true"></span>
                <h2 class="abt-section-heading-text">فروع العائلة الرئيسية</h2>
                <span class="abt-section-heading-line" aria-hidden="true"></span>
            </div>
            <div class="abt-branches-pills">
                <div class="abt-branch-row">
                    @foreach ($branches as $branch)
                        <span class="abt-branch-pill">{{ $branch->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if ($famous->isNotEmpty())
        <section class="abt-famous container" data-animate="fade-up">
            <div class="abt-section-heading">
                <span class="abt-section-heading-line" aria-hidden="true"></span>
                <h2 class="abt-section-heading-text">من مشاهير العائلة</h2>
                <span class="abt-section-heading-line" aria-hidden="true"></span>
            </div>
            <div class="abt-famous-grid">
                @foreach ($famous as $person)
                    <article class="abt-famous-card">
                        @if ($person->photo)
                            <div style="margin-bottom:12px;">
                                <img src="{{ \App\Support\Media::url($person->photo) }}" alt="" style="width:100%;max-height:200px;object-fit:cover;border-radius:8px;" />
                            </div>
                        @endif
                        <div class="abt-famous-info">
                            <h4 class="abt-famous-name"><span class="abt-famous-dot"></span>{{ $person->name }}</h4>
                            @if ($person->line_one)
                                <p>{{ $person->line_one }}</p>
                            @endif
                            @if ($person->line_two)
                                <p>{{ $person->line_two }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection
