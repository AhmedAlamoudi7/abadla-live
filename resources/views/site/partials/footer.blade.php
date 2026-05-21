<div class="about-us">
    <div class="group">
        <div class="group-2">
            {{-- Brown footer band background --}}
            <div class="rectangle-10"></div>
            <img class="vector-5" src="{{ asset('legacy/img/vector-9.svg') }}" alt="" />

            {{-- =================== Newsletter card =================== --}}
            <div class="rectangle-11"></div>
            <h3 class="text-wrapper-5">{{ $site['newsletter_title'] ?? 'للإشتراك في النشرة البريدية' }}</h3>
            <p class="div-3">
                <span class="span">{{ $site['newsletter_subtitle'] ?? 'ابقَ على اطلاع بأحدث أخبار التقنيات من خلال' }} </span>
                <span class="text-wrapper-6">نشرة العبادلة الأسبوعية</span>
            </p>

            {{-- Decorative backgrounds (kept for Figma styling) --}}
            <div class="rectangle-17"></div>
            <div class="rectangle-18"></div>
            <div class="text-wrapper-7">أدخل بريدك الإلكتروني ..</div>
            <div class="text-wrapper-11">إشتراك</div>

            {{-- Real newsletter form overlaid on top --}}
            <form class="newsletter-figma-form" method="post" action="{{ route('newsletter.store') }}">
                @csrf
                <input class="newsletter-figma-input" type="email" name="email" placeholder="أدخل بريدك الإلكتروني .." aria-label="البريد الإلكتروني" required />
                <button class="newsletter-figma-button" type="submit" aria-label="إشتراك"></button>
            </form>

            {{-- =================== Contact form =================== --}}
            <h3 class="text-wrapper-18">للتواصــــل</h3>
            <img class="vector-7" src="{{ asset('legacy/img/Vector-7.svg') }}" alt="" />
            <div class="rectangle-12"></div>
            <div class="rectangle-14"></div>
            <div class="rectangle-15"></div>
            <div class="text-wrapper-8">الإسم كامل *</div>
            <div class="text-wrapper-9">اكتب رسالتك ..</div>
            <div class="text-wrapper-10">رقم الجوال *</div>
            <div class="rectangle-13"></div>
            <div class="text-wrapper-15">إرسال</div>
            <div class="group-4">
                <img class="vector-10" src="{{ asset('legacy/img/arrow.svg') }}" alt="" />
            </div>

            {{-- Real contact form overlaid on top --}}
            <form class="contact-figma-form" method="post" action="{{ route('contact.store') }}">
                @csrf
                <input class="contact-figma-name" type="text" name="name" value="{{ old('name') }}" placeholder="الإسم كامل *" aria-label="الاسم كامل" required />
                <input class="contact-figma-phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال *" aria-label="رقم الجوال" required />
                <textarea class="contact-figma-message" name="message" placeholder="اكتب رسالتك .." aria-label="الرسالة">{{ old('message') }}</textarea>
                <button class="contact-figma-submit" type="submit" aria-label="إرسال"></button>
            </form>

            {{-- =================== Quick links =================== --}}
            <h3 class="text-wrapper-17">روابط تهمك</h3>
            <img class="vector-6" src="{{ asset('legacy/img/Vector-6.svg') }}" alt="" />
            <div class="rectangle-19"></div>

            <nav class="text-wrapper-14" aria-label="روابط رئيسية">
                <a href="{{ route('home') }}">الرئيسية</a><br />
                <a href="{{ route('about') }}">عـــن العائلة</a><br />
                <a href="{{ route('news.index') }}">أخبـار العائلة</a><br />
                <a href="{{ route('social') }}">إجتماعيــات</a>
            </nav>
            <nav class="text-wrapper-16" aria-label="روابط ثانوية">
                <a href="{{ route('personalities') }}">درجات علمية</a><br />
                <a href="{{ route('family-tree') }}">شجرة العائلة</a><br />
                <a href="{{ route('events.index') }}">منـوعـــــات</a><br />
                <a href="{{ route('album') }}">الألــبـــــوم</a>
            </nav>

            {{-- =================== WhatsApp CTA =================== --}}
            <a class="rectangle-16" href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener" aria-label="مجموعة واتساب"></a>
            <a class="div-4-link" href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener">
                <p class="div-4">
                    <span class="text-wrapper-12">{{ $site['whatsapp_line1'] ?? 'للإنضمـ' }}</span><span class="text-wrapper-13">ـــ</span><span class="text-wrapper-12">ام فـي<br />{{ $site['whatsapp_line2'] ?? 'مجموعة واتساب' }}</span>
                </p>
            </a>
            <a class="social-icons-link" href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener" aria-label="واتساب">
                <img class="social-icons" src="{{ asset('legacy/img/whatsapp-big.svg') }}" alt="" />
            </a>

            {{-- =================== Bottom bar =================== --}}
            <img class="vector-8" src="{{ asset('legacy/img/vector-8-2.svg') }}" alt="" />
            <p class="element">
                {{ $site['copyright_line'] ?? ('جميع الحقوق محفوظة لعائلة العبادلة في الوطن والشتات  ' . date('Y')) }}
            </p>

            <div class="group-3">
                @if (!empty($site['social_telegram']) && $site['social_telegram'] !== '#')
                    <a class="social-link social-link--telegram" href="{{ $site['social_telegram'] }}" target="_blank" rel="noopener" aria-label="Telegram">
                        <img class="vector-9" src="{{ asset('legacy/img/telegram.svg') }}" alt="" />
                    </a>
                @endif
                @if (!empty($site['social_youtube']) && $site['social_youtube'] !== '#')
                    <a class="social-link social-link--youtube" href="{{ $site['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube">
                        <img class="social-icons-2" src="{{ asset('legacy/img/youtube.svg') }}" alt="" />
                    </a>
                @endif
                @if (!empty($site['social_instagram']) && $site['social_instagram'] !== '#')
                    <a class="social-link social-link--instagram" href="{{ $site['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram">
                        <img class="social-icons-3" src="{{ asset('legacy/img/insta.svg') }}" alt="" />
                    </a>
                @endif
                @if (!empty($site['social_facebook']) && $site['social_facebook'] !== '#')
                    <a class="social-link social-link--facebook" href="{{ $site['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook">
                        <img class="social-icons-4" src="{{ asset('legacy/img/face.svg') }}" alt="" />
                    </a>
                @endif
                @if (!empty($site['social_x']) && $site['social_x'] !== '#')
                    <a class="social-link social-link--x" href="{{ $site['social_x'] }}" target="_blank" rel="noopener" aria-label="X">
                        <img class="social-icons-5" src="{{ asset('legacy/img/x.svg') }}" alt="" />
                    </a>
                @endif
                @if (!empty($site['social_tiktok'] ?? null) && $site['social_tiktok'] !== '#')
                    <a class="social-link social-link--tiktok" href="{{ $site['social_tiktok'] }}" target="_blank" rel="noopener" aria-label="TikTok">
                        <img class="social-icons-6" src="{{ asset('legacy/img/Vector-tiktok.svg') }}" alt="" />
                    </a>
                @endif
            </div>

            <p class="div-5">
                <a class="text-wrapper-19" href="#">الشروط والأحكام</a><span class="text-wrapper-20">&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; </span><a class="text-wrapper-19" href="#">سياسة الخصوصية</a>
            </p>
            <p class="div-6">
                <span class="text-wrapper-21">تصميم و تطوير <br />علامة ستديو للحلول الرقمية</span>
                <span class="text-wrapper-22"></span>
            </p>
            <img class="image-2" src="{{ asset('legacy/img/image-4.png') }}" alt="" />
        </div>
    </div>
</div>
