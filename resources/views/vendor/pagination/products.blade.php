@if ($paginator->hasPages())
<div>
    <ul class="paging">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page prev disable"><a href="javascript:;"><i class="fa-solid fa-angle-left arrow"></i></a></li>
        @else
            <li class="page prev"><a href="{{ $paginator->previousPageUrl() }}"><i class="fa-solid fa-angle-left arrow"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page disable"><a href="javascript:;">{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page active"><a href="javascript:;">{{ $page }}</a></li>
                    @else
                        <li class="page"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page next"><a href="{{ $paginator->nextPageUrl() }}"><i class="fa-solid fa-angle-right arrow"></i></a></li>
        @else
            <li class="page next disable"><a href="javascript:;"><i class="fa-solid fa-angle-right arrow"></i></a></li>
        @endif
    </ul>
</div>
@endif