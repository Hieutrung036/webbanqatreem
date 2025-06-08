@if ($paginator->hasPages())
    <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="@lang('pagination.first')">
            <span aria-hidden="true">&laquo;</span>
        </a>
    </li>

    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
        @endif
    @endforeach

    <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
        <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="@lang('pagination.last')">
            <span aria-hidden="true">&raquo;</span>
        </a>
    </li>
@endif
