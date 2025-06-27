<div class="col-sm-12">
    Showing {{($paginator->currentpage()-1)*$paginator->perpage()+1}} to {{$paginator->currentpage()*$paginator->perpage()}}
    of  {{$paginator->total()}} entries
</div>
<div class="clearfix"></div>
<div class="col-sm-12">
    @if ($paginator->hasPages())

    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled"><span class="paginate_button">&laquo;</span></li>
        @else
        <li class="page-item"><a class="paginate_button " onclick="return paginate(this);" href="javascript:void(0);" page-href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="page-item disabled"><span class="paginate_button">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item active"><span class="paginate_button">{{ $page }}</span></li>
        @else
        <li class="page-item"><a class="paginate_button " onclick="return paginate(this);" href="javascript:void(0);" page-href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item next-page"><a class="paginate_button " onclick="return paginate(this);" href="javascript:void(0);" page-href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
        <li class="page-item disabled next-page"><span class="paginate_button">&raquo;</span></li>
        @endif
    </ul>
    @endif
</div>