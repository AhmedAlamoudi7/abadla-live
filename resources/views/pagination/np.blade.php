{{-- RTL-friendly numeric pagination matching .np-pagination in legacy/style.css --}}
@if ($paginator->hasPages())
    <div class="np-pagination" role="navigation" aria-label="ترقيم الصفحات">
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
    </div>
@endif
