<footer class="site-footer">
    <div class="site-footer__inner">
        <div class="site-footer__bg"></div>
        <img class="site-footer__caret" src="{{ asset('legacy/img/vector-9.svg') }}" alt="" />

        {{-- ============ Newsletter ============ --}}
        <div class="newsletter"></div>
        <h3 class="newsletter__title">{{ $site['newsletter_title'] ?? 'للإشتراك في النشرة البريدية' }}</h3>
        <p class="newsletter__subtitle">
            <span class="newsletter__subtitle-text">ابقَ على اطلاع بأحدث أخبار التقنيات من خلال </span>
            <span class="newsletter__subtitle-highlight">نشرة العبادلة الأسبوعية</span>
        </p>
        <div class="newsletter__field"></div>
        <div class="newsletter__placeholder">أدخل بريدك الإلكتروني ..</div>
        <div class="newsletter__submit"></div>
        <div class="newsletter__submit-label">إشتراك</div>
        <form class="newsletter__form" method="post" action="{{ route('newsletter.store') }}">
            @csrf
            <input class="newsletter__form-input" type="email" name="email" aria-label="البريد الإلكتروني" required />
            <button class="newsletter__form-button" type="submit" aria-label="إشتراك"></button>
        </form>

        {{-- ============ Contact form ============ --}}
        <h3 class="contact-form__title">للتواصــــل</h3>
        <img class="contact-form__title-underline" src="{{ asset('legacy/img/Vector-7.svg') }}" alt="" />
        <div class="contact-form__message-bg"></div>
        <div class="contact-form__name-bg"></div>
        <div class="contact-form__phone-bg"></div>
        <div class="contact-form__name-placeholder">الإسم كامل *</div>
        <div class="contact-form__message-placeholder">اكتب رسالتك ..</div>
        <div class="contact-form__phone-placeholder">رقم الجوال *</div>
        <div class="contact-form__submit-bg"></div>
        <div class="contact-form__submit-label">إرسال</div>
        <div class="contact-form__submit-arrow">
            <img class="contact-form__submit-arrow-icon" src="{{ asset('legacy/img/arrow.svg') }}" alt="" />
        </div>
        <form class="contact-form" method="post" action="{{ route('contact.store') }}">
            @csrf
            <input class="contact-form__name" type="text" name="name" value="{{ old('name') }}" aria-label="الاسم كامل" required />
            <input class="contact-form__phone" type="text" name="phone" value="{{ old('phone') }}" aria-label="رقم الجوال" required />
            <textarea class="contact-form__message" name="message" aria-label="الرسالة">{{ old('message') }}</textarea>
            <button class="contact-form__submit" type="submit" aria-label="إرسال"></button>
        </form>

        {{-- ============ Quick links ============ --}}
        <h3 class="quick-links__title">روابط تهمك</h3>
        <img class="quick-links__title-underline" src="{{ asset('legacy/img/Vector-6.svg') }}" alt="" />
        <div class="quick-links__divider"></div>
        <nav class="quick-links__col-1">
            <a href="{{ route('home') }}">الرئيسية</a><br />
            <a href="{{ route('about') }}">عـــن العائلة</a><br />
            <a href="{{ route('news.index') }}">أخبـار العائلة</a><br />
            <a href="{{ route('social') }}">إجتماعيــات</a>
        </nav>
        <nav class="quick-links__col-2">
            <a href="{{ route('personalities') }}">درجات علمية</a><br />
            <a href="{{ route('family-tree') }}">شجرة العائلة</a><br />
            <a href="{{ route('events.index') }}">منـوعـــــات</a><br />
            <a href="{{ route('album') }}">الألــبـــــوم</a>
        </nav>

        {{-- ============ WhatsApp CTA ============ --}}
        <a class="whatsapp-cta" href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener" aria-label="مجموعة واتساب"></a>
        <a class="whatsapp-cta__text-link" href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener">
            <span class="whatsapp-cta__text">
                <span class="whatsapp-cta__text-main">للإنضمـ</span><span class="whatsapp-cta__text-dash">ـــ</span><span class="whatsapp-cta__text-main">ام فـي<br />مجموعة واتساب</span>
            </span>
        </a>
        <img class="whatsapp-cta__icon" src="{{ asset('legacy/img/whatsapp-big.svg') }}" alt="" />

        {{-- ============ Bottom bar ============ --}}
        <img class="site-footer__separator" src="{{ asset('legacy/img/vector-8-2.svg') }}" alt="" />
        <p class="site-footer__copyright">
            {{ $site['copyright_line'] ?? ('جميع الحقوق محفوظة لعائلة العبادلة في الوطن والشتات  ' . date('Y')) }}
        </p>

        <div class="social-row">
            @if (!empty($site['social_telegram']))
                <a href="{{ $site['social_telegram'] }}" target="_blank" rel="noopener" aria-label="Telegram"><img class="social-row__telegram" src="{{ asset('legacy/img/telegram.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_youtube']))
                <a href="{{ $site['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><img class="social-row__youtube" src="{{ asset('legacy/img/youtube.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_instagram']))
                <a href="{{ $site['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><img class="social-row__instagram" src="{{ asset('legacy/img/insta.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_facebook']))
                <a href="{{ $site['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><img class="social-row__facebook" src="{{ asset('legacy/img/face.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_x']))
                <a href="{{ $site['social_x'] }}" target="_blank" rel="noopener" aria-label="X"><img class="social-row__x" src="{{ asset('legacy/img/x.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_tiktok']))
                <a href="{{ $site['social_tiktok'] }}" target="_blank" rel="noopener" aria-label="TikTok"><img class="social-row__tiktok" src="{{ asset('legacy/img/Vector-tiktok.svg') }}" alt="" /></a>
            @endif
        </div>

        <p class="site-footer__legal">
            <a class="site-footer__legal-link" href="#">الشروط والأحكام</a><span class="site-footer__legal-sep">&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</span><a class="site-footer__legal-link" href="#">سياسة الخصوصية</a>
        </p>
        <p class="site-footer__credit">
            <span class="site-footer__credit-text">تصميم و تطوير <br />علامة ستديو للحلول الرقمية</span>
        </p>
        <img class="site-footer__credit-logo" src="{{ asset('legacy/img/image-4.png') }}" alt="" />
    </div>
</footer>
