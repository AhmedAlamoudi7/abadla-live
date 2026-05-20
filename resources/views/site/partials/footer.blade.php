<footer class="about-us site-footer">
    <div class="group">
        <div class="group-2">
            <div class="rectangle-10"></div>
            <img class="vector-5" src="{{ asset('legacy/img/vector-9.svg') }}" alt="" />
            <div class="rectangle-11"></div>
            <div class="rectangle-12"></div>
            <div class="rectangle-13"></div>
            <div class="rectangle-14"></div>
            <div class="rectangle-15"></div>
            <a class="rectangle-16" href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"></a>
            <div class="rectangle-17"></div>
            <div class="text-wrapper-5">للإشتراك في النشرة البريدية</div>
            <p class="div-3">
                <span class="span">ابقَ على اطلاع بأحدث أخبار التقنيات من خلال </span>
                <span class="text-wrapper-6">نشرة العبادلة الأسبوعية</span>
            </p>
            <form method="post" action="{{ route('newsletter.store') }}" class="newsletter-form-tech">
                @csrf
                <div class="rectangle-18"></div>
                <input type="email" name="email" class="newsletter-email-input" placeholder="أدخل بريدك الإلكتروني .." required />
                <div class="text-wrapper-7">أدخل بريدك الإلكتروني ..</div>
                <button type="submit" class="newsletter-submit-tech">
                    <span class="text-wrapper-11">إشتراك</span>
                </button>
            </form>
            <form method="post" action="{{ route('contact.store') }}" class="contact-form-tech">
                @csrf
                <input type="text" name="name" class="contact-name-input" placeholder="الإسم كامل *" required />
                <input type="tel" name="phone" class="contact-phone-input" placeholder="رقم الجوال *" required />
                <textarea name="message" class="contact-message-input" placeholder="اكتب رسالتك .." required></textarea>
                <button type="submit" class="contact-submit-tech">
                    <div class="text-wrapper-15">إرسال</div>
                </button>
            </form>
            <div class="text-wrapper-8">الإسم كامل *</div>
            <div class="text-wrapper-9">اكتب رسالتك ..</div>
            <div class="text-wrapper-10">رقم الجوال *</div>
            <div class="rectangle-19"></div>
            <a href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="div-4">
                <span class="text-wrapper-12">للإنضمام</span>
                <span class="text-wrapper-13">إلى</span>
                <span class="text-wrapper-12">مجموعة واتساب</span>
            </a>
            <div class="text-wrapper-14">
                <a href="{{ route('home') }}">الرئيسية</a><br />
                <a href="{{ route('about') }}">عن العائلة</a><br />
                <a href="{{ route('news.index') }}">أخبار العائلة</a><br />
                <a href="{{ route('social') }}">إجتماعيات</a>
            </div>
            <p class="element">{{ $site['copyright_line'] ?? 'جميع الحقوق محفوظة لعائلة العبادلة في الوطن والشتات 2025' }}</p>
            <div class="text-wrapper-16">
                <a href="{{ route('personalities') }}">درجات علمية</a><br />
                <a href="{{ route('family-tree') }}">شجرة العائلة</a><br />
                <a href="{{ route('news.index') }}">منوعات</a><br />
                <a href="{{ route('album') }}">الألبوم</a>
            </div>
            <div class="text-wrapper-17">روابط تهمك</div>
            <div class="text-wrapper-18">للتواصل</div>
            <img class="vector-6" src="{{ asset('legacy/img/Vector-6.svg') }}" alt="" />
            <img class="vector-7" src="{{ asset('legacy/img/Vector-7.svg') }}" alt="" />
            <img class="vector-8" src="{{ asset('legacy/img/vector-8-2.svg') }}" alt="" />
            <img class="social-icons" src="{{ asset('legacy/img/whatsapp-big.svg') }}" alt="" />
            <div class="group-3">
                @if (!empty($site['social_telegram']))
                    <a href="{{ $site['social_telegram'] }}" target="_blank" rel="noopener" aria-label="Telegram"><img class="vector-9" src="{{ asset('legacy/img/telegram.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_youtube']))
                    <a href="{{ $site['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><img class="social-icons-2" src="{{ asset('legacy/img/youtube.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_instagram']))
                    <a href="{{ $site['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><img class="social-icons-3" src="{{ asset('legacy/img/insta.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_facebook']))
                    <a href="{{ $site['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><img class="social-icons-4" src="{{ asset('legacy/img/face.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_x']))
                    <a href="{{ $site['social_x'] }}" target="_blank" rel="noopener" aria-label="X"><img class="social-icons-5" src="{{ asset('legacy/img/x.svg') }}" alt="" /></a>
                @endif
                @if (!empty($site['social_tiktok']))
                    <a href="{{ $site['social_tiktok'] }}" target="_blank" rel="noopener" aria-label="TikTok"><img class="social-icons-6" src="{{ asset('legacy/img/Vector-tiktok.svg') }}" alt="" /></a>
                @endif
            </div>
            <p class="div-5">
                <a class="text-wrapper-19" href="{{ $site['terms_url'] ?? '#' }}">الشروط والأحكام </a>
                <span class="text-wrapper-20">&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <a class="text-wrapper-19" href="{{ $site['privacy_url'] ?? '#' }}">سياسة الخصوصية</a>
            </p>
            <p class="div-6">
                <span class="text-wrapper-21">تصميم و تطوير <br />علامة ستديو للحلول الرقمية</span>
                <span class="text-wrapper-22"></span>
            </p>
            <div class="group-4">
                <img class="vector-10" src="{{ asset('legacy/img/arrow.svg') }}" alt="" />
            </div>
            <img class="image-2" src="{{ asset('legacy/img/image-4.png') }}" alt="" />
        </div>
    </div>
</footer>
