<section class="newsletter-wrapper" data-animate="fade-up">
    <div class="newsletter-box">
        <div class="newsletter-content">
            <h2>{{ $site['newsletter_title'] ?? 'للاشتراك في النشرة البريدية' }}</h2>
            <p>{{ $site['newsletter_subtitle'] ?? '' }}</p>
        </div>
        <form class="newsletter-form" method="post" action="{{ route('newsletter.store') }}">
            @csrf
            <input type="email" name="email" value="{{ old('email') }}" placeholder="أدخل بريدك الإلكتروني" required />
            <button type="submit">اشترك</button>
        </form>
    </div>
    <a class="whatsapp-box" href="{{ $site['whatsapp_url'] ?? '#' }}" target="_blank" rel="noopener noreferrer">
        <img src="{{ asset('legacy/img/Social-Icons2.svg') }}" alt="WhatsApp" />
        <p>{!! nl2br(e(($site['whatsapp_line1'] ?? '')."\n".($site['whatsapp_line2'] ?? ''))) !!}</p>
    </a>
</section>
