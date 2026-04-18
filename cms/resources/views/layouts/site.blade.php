<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>{{ $title ?? 'العبادلة - موقع العائلة' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ $metaDescription ?? '' }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/rawasi-display.css') }}" />
    <link rel="stylesheet" href="{{ asset('legacy/style.css') }}" />
    @stack('styles')
</head>
<body class="@yield('body_class')">
    <img src="{{ asset('legacy/img/Group-126.svg') }}" class="top-ornament" alt="" />

    @include('site.partials.header')

    @include('site.partials.breaking')

    @yield('content')

    @include('site.partials.newsletter')

    @include('site.partials.footer')

    @include('site.partials.video-modal')

    @include('site.partials.scroll-top')

    <script>
        window.SITE_SEARCH_PAGES = @json($siteSearchPages ?? []);
        window.GALLERY_MORE_URL = @json(route('album'));
    </script>
    @stack('before_legacy_script')
    <script src="{{ asset('legacy/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
