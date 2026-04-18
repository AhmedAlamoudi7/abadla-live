@php($nav = $activeNav ?? '')
<header class="header container" id="header">
    <div class="header-right">
        <nav class="nav" id="navMenu">
            <a href="{{ route('home') }}" class="{{ $nav === 'home' ? 'active' : '' }}">الرئيسية</a>
            <a href="{{ route('about') }}" class="{{ $nav === 'about' ? 'active' : '' }}">عن العائلة</a>
            <a href="{{ route('news.index') }}" class="{{ $nav === 'news' ? 'active' : '' }}">أخبار العائلة</a>
            <a href="{{ route('events.index') }}" class="{{ $nav === 'events' ? 'active' : '' }}">فعاليات</a>
            <a href="{{ route('social') }}" class="{{ $nav === 'social' ? 'active' : '' }}">إجتماعيات</a>
            <a href="{{ route('family-tree') }}" class="{{ $nav === 'family-tree' ? 'active' : '' }}">شجرة العائلة</a>
            <a href="{{ route('personalities') }}" class="{{ $nav === 'personalities' ? 'active' : '' }}">شخصيات إعتبارية</a>
            <a href="{{ route('album') }}" class="{{ $nav === 'album' ? 'active' : '' }}">الألبوم</a>
        </nav>

        <div class="tools">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input class="search" type="text" placeholder="ابحث هنا" id="siteSearch" name="q" autocomplete="off" />
                <div class="search-dropdown" id="searchDropdown"></div>
            </div>
        </div>
    </div>

    <button class="mobile-toggle" id="mobileToggle" aria-label="القائمة">
        <span></span><span></span><span></span>
    </button>
</header>
