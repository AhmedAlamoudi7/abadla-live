<footer class="footer">
    <form class="footer-top" method="post" action="{{ route('contact.store') }}">
        @csrf

        {{-- WhatsApp join box (right side, RTL start) --}}
        <a class="footer-whatsapp" href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
            <img src="{{ asset('legacy/img/whatsapp-big.svg') }}" alt="" />
            <p>
                <span>للإنضمام</span>
                <span>إلى</span>
                <span>مجموعة واتساب</span>
            </p>
        </a>

        {{-- Contact column --}}
        <div class="footer-box footer-contact">
            <h3>للتواصل</h3>
            <span class="footer-rule" aria-hidden="true"></span>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="الإسم كامل *" required />
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال *" required />
            <textarea name="message" placeholder="اكتب رسالتك .." required>{{ old('message') }}</textarea>
            <button type="submit" class="footer-send">إرسال</button>
        </div>

        {{-- Links column --}}
        <div class="footer-box footer-links">
            <h3>روابط تهمك</h3>
            <span class="footer-rule" aria-hidden="true"></span>
            <div class="links-columns">
                <ul>
                    <li><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li><a href="{{ route('about') }}">عن العائلة</a></li>
                    <li><a href="{{ route('news.index') }}">أخبار العائلة</a></li>
                    <li><a href="{{ route('social') }}">إجتماعيات</a></li>
                </ul>
                <ul>
                    <li><a href="{{ route('personalities') }}">درجات علمية</a></li>
                    <li><a href="{{ route('family-tree') }}">شجرة العائلة</a></li>
                    <li><a href="{{ route('news.index') }}">منوعات</a></li>
                    <li><a href="{{ route('album') }}">الألبوم</a></li>
                </ul>
            </div>
        </div>
    </form>

    {{-- Divider line between form area and copyright row --}}
    <div class="footer-divider" aria-hidden="true"></div>

    <div class="footer-bottom">
        <div class="footer-social">
            @if (!empty($site['social_tiktok']))
                <a href="{{ $site['social_tiktok'] }}" target="_blank" rel="noopener" aria-label="TikTok"><img src="{{ asset('legacy/img/Vector-tiktok.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_x']))
                <a href="{{ $site['social_x'] }}" target="_blank" rel="noopener" aria-label="X"><img src="{{ asset('legacy/img/x.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_facebook']))
                <a href="{{ $site['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><img src="{{ asset('legacy/img/face.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_instagram']))
                <a href="{{ $site['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><img src="{{ asset('legacy/img/insta.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_youtube']))
                <a href="{{ $site['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><img src="{{ asset('legacy/img/youtube.svg') }}" alt="" /></a>
            @endif
            @if (!empty($site['social_telegram']))
                <a href="{{ $site['social_telegram'] }}" target="_blank" rel="noopener" aria-label="Telegram"><img src="{{ asset('legacy/img/telegram.svg') }}" alt="" /></a>
            @endif
        </div>

        <p class="footer-copy">{{ $site['copyright_line'] ?? 'جميع الحقوق محفوظة لعائلة العبادلة في الوطن والشتات 2025' }}</p>

        <p class="footer-legal">
            <a href="{{ $site['terms_url'] ?? '#' }}">الشروط والأحكام</a>
            <span aria-hidden="true">|</span>
            <a href="{{ $site['privacy_url'] ?? '#' }}">سياسة الخصوصية</a>
        </p>

        <p class="footer-credit">{{ $site['footer_legal'] ?? 'تصميم و تطوير علامة ستديو للحلول الرقمية' }}</p>
    </div>
</footer>
