@if (session('contact_ok'))
    <div class="container" style="padding:12px 0;text-align:center;color:#0a7a3e;font-weight:600;">
        تم استلام رسالتك بنجاح.
    </div>
@endif

<footer class="footer">
    <form class="footer-top" method="post" action="{{ route('contact.store') }}">
        @csrf
        <div class="footer-box footer-links">
            <h3>روابط تهمك</h3>
            <div class="links-columns">
                <ul>
                    <li><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li><a href="{{ route('about') }}">عن العائلة</a></li>
                    <li><a href="{{ route('news.index') }}">أخبار العائلة</a></li>
                    <li><a href="{{ route('social') }}">إجتماعيات</a></li>
                </ul>
                <ul>
                    <li><a href="{{ route('news.index') }}">درجات علمية</a></li>
                    <li><a href="{{ route('family-tree') }}">شجرة العائلة</a></li>
                    <li><a href="{{ route('album') }}">الألبوم</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-box footer-contact">
            <h3>للتواصل</h3>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="الاسم كامل" required />
            <div class="phone-input">
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="رقم الهاتف" required />
            </div>
        </div>

        <div class="footer-box footer-message">
            <div class="social-icons">
                <a href="{{ $site['social_facebook'] ?? '#' }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="{{ $site['social_instagram'] ?? '#' }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="{{ $site['social_youtube'] ?? '#' }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="{{ $site['social_x'] ?? '#' }}" target="_blank" rel="noopener" aria-label="X"><i class="fab fa-x-twitter"></i></a>
                <a href="{{ $site['social_telegram'] ?? '#' }}" target="_blank" rel="noopener" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
            </div>
            <textarea name="message" placeholder="اكتب رسالتك..." required>{{ old('message') }}</textarea>
            <button type="submit">إرسال</button>
        </div>
    </form>

    <div class="footer-bottom">
        <span>{{ $site['footer_legal'] ?? '' }}</span>
        <span>{{ $site['copyright_line'] ?? '' }}</span>
    </div>
</footer>
