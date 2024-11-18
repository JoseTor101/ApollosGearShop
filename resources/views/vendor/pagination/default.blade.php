@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-1 py-0.5 text-[10px] font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed" aria-disabled="true">
                    <svg class="w-2 h-2 !important" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg> <!-- Left arrow -->
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-1 py-0.5 text-[10px] font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-100">
                    <svg class="w-2 h-2 !important" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg> <!-- Left arrow -->
                </a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-1 py-0.5 text-[10px] font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-100">
                    <svg class="w-2 h-2 !important" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg> <!-- Right arrow -->
                </a>
            @else
                <span class="relative inline-flex items-center px-1 py-0.5 text-[10px] font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed" aria-disabled="true">
                    <svg class="w-2 h-2 !important" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg> <!-- Right arrow -->
                </span>
            @endif
        </div>
    </nav>
@endif
