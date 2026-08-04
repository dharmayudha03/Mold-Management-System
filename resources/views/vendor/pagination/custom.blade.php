@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex align-items-center justify-content-between flex-wrap gap-3 w-100 py-1">
        <!-- Left side: Information Text in Bahasa Indonesia -->
        <div class="text-xs text-gray-700 font-weight-extrabold d-flex align-items-center gap-1">
            Menampilkan
            @if ($paginator->firstItem())
                <span class="font-weight-black text-gray-900 px-1 py-0.5 bg-light rounded" style="color: #0f172a !important;">{{ $paginator->firstItem() }}</span>
                sampai
                <span class="font-weight-black text-gray-900 px-1 py-0.5 bg-light rounded" style="color: #0f172a !important;">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            dari
            <span class="font-weight-black text-gray-900 px-1 py-0.5 bg-light rounded" style="color: #0f172a !important;">{{ $paginator->total() }}</span>
            total data
        </div>

        <!-- Right side: Sleek Modern Pagination Controls -->
        <ul class="pagination pagination-sm mb-0 d-flex align-items-center gap-1 border-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 text-gray-300 bg-gray-100 d-inline-flex align-items-center justify-content-center" style="border-radius: 0.6rem; width: 34px; height: 34px; cursor: not-allowed;">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link border-0 text-gray-700 bg-white shadow-xs d-inline-flex align-items-center justify-content-center hover:bg-gray-100 transition-all" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="border-radius: 0.6rem; width: 34px; height: 34px; border: 1px solid #e2e8f0 !important;">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link border-0 text-gray-400 bg-transparent px-2 font-weight-bold">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link border-0 text-white font-weight-black d-inline-flex align-items-center justify-content-center" style="border-radius: 0.6rem; min-width: 34px; height: 34px; padding: 0 0.5rem; background-color: #2563eb !important; box-shadow: 0 4px 10px rgba(37,99,235,0.3) !important;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link border-0 text-gray-800 font-weight-bold bg-white shadow-xs d-inline-flex align-items-center justify-content-center hover:bg-gray-100 transition-all" href="{{ $url }}" style="border-radius: 0.6rem; min-width: 34px; height: 34px; padding: 0 0.5rem; border: 1px solid #e2e8f0 !important; color: #1e293b !important;">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link border-0 text-gray-700 bg-white shadow-xs d-inline-flex align-items-center justify-content-center hover:bg-gray-100 transition-all" href="{{ $paginator->nextPageUrl() }}" rel="next" style="border-radius: 0.6rem; width: 34px; height: 34px; border: 1px solid #e2e8f0 !important;">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 text-gray-300 bg-gray-100 d-inline-flex align-items-center justify-content-center" style="border-radius: 0.6rem; width: 34px; height: 34px; cursor: not-allowed;">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
