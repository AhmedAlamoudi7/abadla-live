@extends('layouts.site')

@php
    use App\Support\Media;
    $galleryUrls = $galleryImages->isNotEmpty()
        ? $galleryImages->map(fn ($g) => Media::url($g->image))->values()->all()
        : [
            asset('legacy/img/library-image.png'),
            asset('legacy/img/library-image.png'),
            asset('legacy/img/library-image.png'),
        ];
@endphp

@section('content')
    <section class="hero container" data-animate="fade-up">
        <div class="hero-image hero-slider">
            <span class="date">{{ $heroDateLine }}</span>
            @php
                $slides = $heroSlides->isNotEmpty()
                    ? $heroSlides
                    : collect([null, null, null]);
                $fallbackBanners = ['legacy/img/banner.jpg', 'legacy/img/banner2.jpg', 'legacy/img/banner3.jpg'];
            @endphp
            @foreach ($slides as $i => $slide)
                @php
                    $src = $slide && ($slide->image ?? null)
                        ? Media::url($slide->image, asset($fallbackBanners[$i % 3]))
                        : asset($fallbackBanners[$i % 3]);
                @endphp
                <img src="{{ $src }}" class="slide {{ $i === 0 ? 'active' : '' }}" loading="lazy" alt="" />
            @endforeach
            <div class="slider-dots"></div>
        </div>
    </section>

    <section class="family-events">
        <div class="container">
            <div class="events-row" data-animate="fade-up">
                @foreach ($featuredEvents->take(3) as $i => $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="event-card {{ $i === 0 ? 'active' : '' }}">
                        <span class="event-date">
                            @if ($event->starts_at)
                                {{ $event->starts_at->locale('ar')->translatedFormat('j F Y') }}
                            @endif
                        </span>
                        <h3>{{ $event->title }}</h3>
                        <p>{{ $event->location }}</p>
                        @if ($event->cover_image)
                            <img src="{{ Media::url($event->cover_image) }}" alt="" />
                        @else
                            <img src="{{ asset('legacy/img/event'.($i % 3 + 1).'.jpg') }}" alt="" />
                        @endif
                        <span class="event-btn">مشاهدة المزيد <img src="{{ asset('legacy/img/arrow-left.svg') }}" class="btn-icon" alt="" /></span>
                    </a>
                    @if ($i === 0)
                        <button class="arrow right" type="button" aria-label="التالي">›</button>
                    @endif
                    @if ($i === 1)
                        <button class="arrow left" type="button" aria-label="السابق">‹</button>
                    @endif
                @endforeach
            </div>

            <section class="family-desc section-home-motion" data-animate="fade-up">
                <div class="container family-desc-inner">
                    <div class="family-title" data-animate="fade-right">
                        <h2>{{ $familyIntroTitle }}</h2>
                    </div>
                    <div class="family-text" data-animate="fade-left">
                        @if ($familyIntroHtml)
                            <div class="article-text">{!! $familyIntroHtml !!}</div>
                        @else
                            <p class="article-text">يُدار هذا النص من لوحة التحكم — أضف مقدمة عن العائلة من إعدادات الموقع أو من لوحة Filament.</p>
                        @endif
                    </div>
                </div>
            </section>

            <section class="media-showcase section-home-motion" data-animate="fade-up">
                <div class="container">
                    <div class="media-wrapper">
                        <a href="{{ route('articles.index') }}" class="media-block articles" aria-label="{{ $mediaArticlesLabel }}">
                            <div class="media-head"><h3>{{ $mediaArticlesLabel }}</h3></div>
                            <div class="articles-image">
                                <img src="{{ Media::settingImage($mediaArticlesImage ?? null, 'img/article.jpg') }}" alt="{{ $mediaArticlesLabel }}" />
                            </div>
                        </a>
                        <div class="media-block video">
                            <div class="media-head"><h3>برومو ومقاطع فيديو</h3></div>
                            <div class="video-box" data-video-url="{{ e($mediaVideoUrl) }}"><span class="play-btn">▶</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-title" data-animate="fade-up">
                <div class="title-wrapper">
                    <span class="line"></span>
                    <h2 class="gradient-text">تصفح الفعاليات</h2>
                    <span class="line"></span>
                </div>
            </section>

            <div class="activites-row" data-animate="fade-up">
                @foreach ($activityEvents->take(3) as $i => $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="activity-card {{ $i === 0 ? 'active' : '' }}">
                        @if ($event->cover_image)
                            <img class="activity-img" src="{{ Media::url($event->cover_image) }}" alt="" />
                        @else
                            <img class="activity-img" src="{{ asset('legacy/img/event'.($i % 3 + 1).'.jpg') }}" alt="" />
                        @endif
                        <div class="activity-info">
                            <h3>{{ $event->title }}</h3>
                            <div class="activity-meta">
                                <span class="activity-date">
                                    @if ($event->starts_at)
                                        {{ $event->starts_at->locale('ar')->translatedFormat('j F Y') }}
                                    @endif
                                </span>
                                <img src="{{ asset('legacy/img/arrow-left.svg') }}" class="activity-arrow" alt="" />
                            </div>
                        </div>
                    </a>
                    @if ($i === 0)
                        <button class="arrow-activty right" type="button" aria-label="التالي">›</button>
                    @endif
                    @if ($i === 1)
                        <button class="arrow-activty left" type="button" aria-label="السابق">‹</button>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="family-stats section-home-motion" data-animate="fade-up">
        <div class="container">
            <h2 class="stats-title gradient-text">إحصائيات العائلة</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-label">إجمالي الإناث</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statFemale) ?: 0 }}">0</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">إجمالي الذكور</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statMale) ?: 0 }}">0</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">على قيد الحياة</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statAlive) ?: 0 }}">0</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">إجمالي عدد الأفراد</span>
                    <span class="stat-number" data-target="{{ preg_replace('/\D/', '', $statTotal) ?: 0 }}">0</span>
                </div>
            </div>
            <div class="stats-wide">
                <div class="wide-card">
                    <span class="wide-label">{{ $statWideOneLabel }}</span>
                    <span class="wide-value">{{ $statWideOneValue }}</span>
                </div>
                <div class="wide-card">
                    <span class="wide-label">{{ $statWideTwoLabel }}</span>
                    <span class="wide-value">{{ $statWideTwoValue }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="library-images section-home-motion" data-animate="fade-up">
        <div class="container">
            <section class="landmark-section">
                <div class="landmark-card" data-animate="fade-up" data-delay="100">
                    <button class="nav-arrow" type="button" aria-label="التالي">
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </button>
                    <div class="landmark-content">
                        <h2 class="landmark-title">
                            {{ $landmarkTitle }}
                            <span class="dash"></span>
                        </h2>
                        @if ($landmarkBodyHtml)
                            <div class="landmark-body">{!! $landmarkBodyHtml !!}</div>
                        @else
                            <p>يُدار هذا القسم من لوحة التحكم.</p>
                        @endif
                        <a href="{{ $landmarkMoreUrl }}" class="more-btn">
                            مشاهدة المزيد
                            <span class="btn-arrow" aria-hidden="true">←</span>
                        </a>
                    </div>
                    <div class="landmark-image">
                        <img src="{{ Media::settingImage($landmarkImage ?? null, 'img/jureselem.png') }}" alt="معلم تاريخي" />
                    </div>
                </div>
            </section>
        </div>
    </section>

    <section class="gallery-section">
        <div class="gallery-wrapper">
            <div class="gallery-grid" id="galleryGrid"></div>
        </div>
    </section>

    <div class="lightbox" id="lightbox">
        <span class="close">&times;</span>
        <img id="lightboxImg" alt="Gallery preview" />
    </div>

    <section class="form-section" data-animate="fade-up">
        <div class="form-box">
            <div class="form-info">
                <h2>أضف بياناتك</h2>
                <p>يرجى تعبئة جميع البيانات صحيحة ومحدثة<br />لإضافتها لأرشيف العائلة</p>
                <div class="type-buttons">
                    <button type="button" class="type-btn active" data-archive-type="أفراد">أفراد</button>
                    <button type="button" class="type-btn" data-archive-type="عائلة">عائلة</button>
                    <button type="button" class="type-btn" data-archive-type="مغترب">مغترب</button>
                    <button type="button" class="type-btn" data-archive-type="أخرى">أخرى</button>
                </div>
            </div>

            <form class="form-fields" method="post" action="{{ route('archive-submissions.store') }}">
                @csrf
                <input type="hidden" name="type" id="archiveTypeField" value="أفراد" />
                <div class="field">
                    <label>الاسم بالكامل <span>*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="ادخل الاسم" required />
                </div>
                <div class="field">
                    <label>رقم الجوال <span>*</span></label>
                    <div class="phone-input">
                        <select name="phone_country" aria-label="رمز الدولة">
                            <option value="+970" @selected(old('phone_country', '+970') === '+970')>+970</option>
                            <option value="+972" @selected(old('phone_country') === '+972')>+972</option>
                        </select>
                        <input type="tel" name="phone_number" value="{{ old('phone_number') }}" placeholder="00 000 0000" required />
                    </div>
                </div>
                <div class="field">
                    <label>البريد الإلكتروني <span>*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="ادخل البريد الإلكتروني" required />
                </div>
                <button type="submit" class="submit-btn">إرسال</button>
            </form>
        </div>
    </section>
@endsection

@push('before_legacy_script')
    <script>
        window.MEDIA_VIDEO_URL = @json($mediaVideoUrl ?: '');
        window.GALLERY_IMAGES = @json($galleryUrls);
    </script>
@endpush

@push('scripts')
    <script>
        document.querySelectorAll('.form-section .type-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var v = btn.getAttribute('data-archive-type');
                var field = document.getElementById('archiveTypeField');
                if (v && field) field.value = v;
            });
        });
    </script>
@endpush
