<div>
    @if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <li class="page-item disabled" wire:click="previousPage" rel="prev">
                <a class="page-link">Previous</a>
            </li>
            @else
            <li class="page-item" wire>
                <a class="page-link">Previous</a>
            </li>
            @endif

            @foreach ($elements as $element)
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="page-item bg-primary" wire:click="gotoPage({{$page}})"><a class="page-link bg-primary text-white">{{$page}}</a></li>
            @else
            <li class="page-item"><a class="page-link" wire:click="gotoPage({{$page}})">{{$page}}</a></li>
            @endif
            @endforeach
            @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li class="page-item" wire:click="nextPage" rel="next">
                <a class="page-link">Next</a>
            </li>
            @else
            <li class="page-item disabled">
                <a class="page-link">Next</a>
            </li>
            @endif
        </ul>
    </nav>
    @endif
</div>