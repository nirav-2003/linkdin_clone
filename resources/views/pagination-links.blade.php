@if ($paginator->hasPages())
<div class="demo">
    <nav class="pagination-outer" aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item">
                @if ($paginator->onFirstPage())
                <a href="javascript:void(0)" class="page-link" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
                @else
                <a href="#" wire:click='previousPage' class="page-link" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
                @endif
            </li>
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            @if ($page == $paginator->currentPage())
                            {{-- <span class="page-link"><a href="" class="page-link">{{ $page }}</span> --}}
                            <a href="#" wire:click='gotoPage({{ $page }})' class="page-link">{{ $page }}</a>
                            @else
                            <a href="#" wire:click='gotoPage({{ $page }})' class="page-link">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
            <li class="page-item">
                @if ($paginator->hasMorePages())
                    <a href="#" wire:click='nextPage' class="page-link" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                @else
                    <a href="javascript:void(0)" class="page-link" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                @endif
            </li>
        </ul>
    </nav>
</div>
@endif