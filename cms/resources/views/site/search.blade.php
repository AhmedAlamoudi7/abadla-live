@extends('layouts.site')

@section('content')
    <section class="container" style="padding:40px 0;" data-animate="fade-up">
        <h1 class="gradient-text" style="text-align:center;">بحث</h1>
        <form method="get" action="{{ route('search') }}" style="max-width:520px;margin:24px auto;display:flex;gap:8px;">
            <input type="search" name="q" value="{{ $query }}" placeholder="اكتب كلمة البحث" class="search" style="flex:1;padding:12px;border-radius:8px;border:1px solid #ddd;" />
            <button type="submit" class="submit-btn" style="padding:12px 20px;">بحث</button>
        </form>

        @if ($query === '')
            <p style="text-align:center;opacity:.8;">أدخل كلمة للبحث في الأخبار والفعاليات والشخصيات وأفراد العائلة.</p>
        @else
            <div style="max-width:880px;margin:0 auto;">
                <h2 style="font-size:1.1rem;margin:24px 0 12px;">الأخبار</h2>
                <ul style="list-style:none;padding:0;">
                    @forelse ($results['news'] as $post)
                        <li style="margin-bottom:12px;"><a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a></li>
                    @empty
                        <li style="opacity:.7;">لا نتائج.</li>
                    @endforelse
                </ul>

                <h2 style="font-size:1.1rem;margin:24px 0 12px;">الفعاليات</h2>
                <ul style="list-style:none;padding:0;">
                    @forelse ($results['events'] as $event)
                        <li style="margin-bottom:12px;"><a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a></li>
                    @empty
                        <li style="opacity:.7;">لا نتائج.</li>
                    @endforelse
                </ul>

                <h2 style="font-size:1.1rem;margin:24px 0 12px;">الشخصيات</h2>
                <ul style="list-style:none;padding:0;">
                    @forelse ($results['personalities'] as $p)
                        <li style="margin-bottom:12px;">{{ $p->full_name }}</li>
                    @empty
                        <li style="opacity:.7;">لا نتائج.</li>
                    @endforelse
                </ul>

                <h2 style="font-size:1.1rem;margin:24px 0 12px;">أفراد الشجرة</h2>
                <ul style="list-style:none;padding:0;">
                    @forelse ($results['members'] as $m)
                        <li style="margin-bottom:12px;">{{ $m->full_name }} @if ($m->role) — {{ $m->role }} @endif</li>
                    @empty
                        <li style="opacity:.7;">لا نتائج.</li>
                    @endforelse
                </ul>
            </div>
        @endif
    </section>
@endsection
