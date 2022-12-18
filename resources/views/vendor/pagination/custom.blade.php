@if ($paginator->hasPages())
<div class="table-paging">
    <ul>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="disabled"><a href="javascript:;"><i class="fa-solid fa-arrow-left-long"></i> Trước</a></li>
        @else
        <li><a href="{{ $paginator->previousPageUrl() }}"><i class="fa-solid fa-arrow-left-long"></i> Trước</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disable"><a href="javascript:;">{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><a href="javascript:;">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">Tiếp theo <i class="fa-solid fa-arrow-right-long"></i></a></li>
        @else
            <li class="disable"><a href="javascript:;">Tiếp theo <i class="fa-solid fa-arrow-right-long"></i></a></li>
        @endif
    </ul>
</div>
@endif