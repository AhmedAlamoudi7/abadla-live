<footer class="footer">
    {{-- ============ TOP : Newsletter + WhatsApp ============ --}}
    <div class="footer-top">
        <div class="newsletter-box">
            <a href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener" class="newsletter-side">
                <span class="whatsapp-circle"><i class="fab fa-whatsapp"></i></span>
                <p class="whatsapp-text">
                    للإنضمـ<span class="dash">ـــ</span>ام فـي<br>
                    مجموعة واتساب
                </p>
            </a>

            <div class="newsletter-main">
                <h3 class="newsletter-title">{{ $site['newsletter_title'] ?? 'للإشتراك في النشرة البريدية' }}</h3>
                <p class="newsletter-sub">
                    ابقَ على اطلاع بأحدث أخبار التقنيات من خلال
                    <span class="hl">نشرة العبادلة الأسبوعية</span>
                </p>
                <form class="newsletter-input" method="post" action="{{ route('newsletter.store') }}">
                    @csrf
                    <input type="email" name="email" placeholder="أدخل بريدك الإلكتروني .." required />
                    <button type="submit" class="newsletter-btn">إشتراك</button>
                </form>
            </div>
        </div>
    </div>

    {{-- ============ MID : Contact form + Quick links ============ --}}
    <div class="footer-mid">
        <div class="footer-col">
            <h3 class="footer-heading">للتواصــــل</h3>
            <form class="contact-fields" method="post" action="{{ route('contact.store') }}">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="الإسم كامل *" required />
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال *" required />
                <textarea name="message" placeholder="اكتب رسالتك ..">{{ old('message') }}</textarea>
                <button type="submit" class="send-btn">إرسال</button>
            </form>
        </div>

        <div class="footer-col">
            <h3 class="footer-heading">روابط تهمك</h3>
            <ul class="footer-links">
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('about') }}">عـــن العائلة</a></li>
                <li><a href="{{ route('news.index') }}">أخبـار العائلة</a></li>
                <li><a href="{{ route('social') }}">إجتماعيــات</a></li>
            </ul>
            <ul class="footer-links">
                <li><a href="{{ route('personalities') }}">درجات علمية</a></li>
                <li><a href="{{ route('family-tree') }}">شجرة العائلة</a></li>
                <li><a href="{{ route('events.index') }}">منـوعـــــات</a></li>
                <li><a href="{{ route('album') }}">الألــبـــــوم</a></li>
            </ul>
        </div>
    </div>

    {{-- ============ BOTTOM : Socials + Legal + Credit ============ --}}
    <div class="footer-bottom">
        <div class="footer-social">
            @if (!empty($site['social_telegram']))
                <a class="social-dot" href="{{ $site['social_telegram'] }}" target="_blank" rel="noopener" aria-label="Telegram"><i class="fab fa-telegram-plane"></i></a>
            @endif
            @if (!empty($site['social_youtube']))
                <a class="social-dot" href="{{ $site['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            @endif
            @if (!empty($site['social_instagram']))
                <a class="social-dot" href="{{ $site['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            @endif
            @if (!empty($site['social_facebook']))
                <a class="social-dot" href="{{ $site['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if (!empty($site['social_x']))
                <a class="social-dot" href="{{ $site['social_x'] }}" target="_blank" rel="noopener" aria-label="X"><i class="fab fa-x-twitter"></i></a>
            @endif
            @if (!empty($site['social_tiktok']))
                <a class="social-dot" href="{{ $site['social_tiktok'] }}" target="_blank" rel="noopener" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            @endif
        </div>

        <p class="footer-legal">
            <span class="underline">الشروط والأحكام</span>
            <span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
            <span class="underline">سياسة الخصوصية</span>
        </p>

        <p class="footer-copy">
            {{ $site['copyright_line'] ?? 'جميع الحقوق محفوظة لعائلة العبادلة في الوطن والشتات  ' . date('Y') }}
        </p>

        <p class="footer-credit">
            تصميم و تطوير<br>علامة ستديو للحلول الرقمية
        </p>
    </div>
</footer>
