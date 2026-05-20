<footer class="ftr2">
    {{-- Cream newsletter card that overlaps the brown band --}}
    <div class="ftr2-newsletter">
        <div class="ftr2-newsletter-inner">
            <div class="ftr2-newsletter-text">
                <h2>للإشتراك في النشرة البريدية</h2>
                <p>
                    ابقَ على اطلاع بأحدث أخبار التقنيات من خلال
                    <strong>نشرة العبادلة الأسبوعية</strong>
                </p>
            </div>
            <form method="post" action="{{ route('newsletter.store') }}" class="ftr2-newsletter-form">
                @csrf
                <input type="email" name="email" placeholder="أدخل بريدك الإلكتروني .." required />
                <button type="submit">إشتراك</button>
            </form>
        </div>
    </div>

    {{-- Brown body --}}
    <div class="ftr2-body">
        <div class="ftr2-grid">

            {{-- WhatsApp join card (right / RTL start) --}}
            <a class="ftr2-whatsapp" href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                <img src="{{ asset('legacy/img/whatsapp-big.svg') }}" alt="" />
                <p>للإنضمام إلى<br/>مجموعة واتساب</p>
            </a>

            {{-- Contact form column --}}
            <form method="post" action="{{ route('contact.store') }}" class="ftr2-contact">
                @csrf
                <h3 class="ftr2-col-heading">للتواصل</h3>
                <span class="ftr2-col-rule" aria-hidden="true"></span>
                <div class="ftr2-contact-row">
                    <input type="text" name="name" placeholder="الإسم كامل *" required />
                    <input type="tel" name="phone" placeholder="رقم الجوال *" required />
                </div>
                <textarea name="message" placeholder="اكتب رسالتك .." required></textarea>
                <button type="submit" class="ftr2-contact-submit">إرسال</button>
            </form>

            {{-- Links column --}}
            <nav class="ftr2-links" aria-label="روابط تهمك">
                <h3 class="ftr2-col-heading">روابط تهمك</h3>
                <span class="ftr2-col-rule" aria-hidden="true"></span>
                <div class="ftr2-links-cols">
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
            </nav>
        </div>

        <hr class="ftr2-divider" aria-hidden="true" />

        <div class="ftr2-bottom">
            <div class="ftr2-social">
                @if (!empty($site['social_telegram']))
                    <a href="{{ $site['social_telegram'] }}" target="_blank" rel="noopener" aria-label="Telegram"><img src="{{ asset('legacy/img/telegram.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_youtube']))
                    <a href="{{ $site['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><img src="{{ asset('legacy/img/youtube.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_instagram']))
                    <a href="{{ $site['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><img src="{{ asset('legacy/img/insta.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_facebook']))
                    <a href="{{ $site['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><img src="{{ asset('legacy/img/face.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_x']))
                    <a href="{{ $site['social_x'] }}" target="_blank" rel="noopener" aria-label="X"><img src="{{ asset('legacy/img/x.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_tiktok']))
                    <a href="{{ $site['social_tiktok'] }}" target="_blank" rel="noopener" aria-label="TikTok"><img src="{{ asset('legacy/img/Vector-tiktok.svg') }}" alt="" /></a>
                @endif
            </div>

            <p class="ftr2-copy">{{ $site['copyright_line'] ?? 'جميع الحقوق محفوظة لعائلة العبادلة في الوطن والشتات 2025' }}</p>

            <p class="ftr2-legal">
                <a href="{{ $site['terms_url'] ?? '#' }}">الشروط والأحكام</a>
                <span aria-hidden="true">|</span>
                <a href="{{ $site['privacy_url'] ?? '#' }}">سياسة الخصوصية</a>
            </p>

            <p class="ftr2-credit">{{ $site['footer_legal'] ?? 'تصميم و تطوير علامة ستديو للحلول الرقمية' }}</p>
        </div>
    </div>
</footer>
