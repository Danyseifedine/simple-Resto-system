@props(['data', 'emptyText' => '', 'emptyImage' => ''])
@if ($data->hasPages() || $data->total() > 0)
    <div class="d-flex justify-content-center p-8">
        <nav aria-label="Page navigation" class="pagination-wrapper">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($data->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item prev-item">
                        <a class="page-link" href="#" data-page="{{ $data->currentPage() - 1 }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @for ($page = 1; $page <= $data->lastPage(); $page++)
                    @if ($page == $data->currentPage())
                        <li class="page-item active">
                            <span class="page-link" style="pointer-events: none;">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="{{ $page }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endfor

                {{-- Next Page Link --}}
                @if ($data->hasMorePages())
                    <li class="page-item next-item">
                        <a class="page-link" href="#" data-page="{{ $data->currentPage() + 1 }}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@else
    <div class="d-flex justify-content-center flex-column align-items-center" style="min-height: 50vh;">
        <div class="text-center">
            <img src="{{ asset($emptyImage, true) }}" class="mw-250px mb-7" alt="">
            <h3 class="text-gray-600 fw-bolder fs-2">{{ $emptyText }}</h3>
        </div>
    </div>
@endif
