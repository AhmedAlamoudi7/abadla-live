{{-- RTL-friendly numeric pagination with prev/next arrows. Matches .np-pagination in legacy/style.css --}}
@pushOnce('styles', 'pagination-np-a')
    <style>
        a.np-page { text-decoration: none; color: inherit; }
        .np-page--nav { width: 40px; }
        .np-page--nav i { font-size: 12px; line-height: 1; }
        .np-page.is-disabled { opacity: .45; cursor: not-allowed; pointer-events: none; }
        .np-page--ellipsis { border: none; background: transparent; width: auto; min-width: 20px; }
    </style>
@endPushOnce
@if ($paginator->hasPages())
    <div class="np-pagination" role="navigation" aria-label="ترقيم الصفحات">
        @if ($paginator->onFirstPage())
            <span class="np-page np-page--nav is-disabled" aria-disabled="true" aria-label="الصفحة السابقة">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="np-page np-page--nav" rel="prev" aria-label="الصفحة السابقة">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="np-page np-page--ellipsis" aria-hidden="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="np-page active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="np-page">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="np-page np-page--nav" rel="next" aria-label="الصفحة التالية">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </a>
        @else
            <span class="np-page np-page--nav is-disabled" aria-disabled="true" aria-label="الصفحة التالية">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </span>
        @endif
    </div>
@endif
