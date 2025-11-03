<nav class="flex items-center justify-center space-x-1" aria-label="Pagination">
    @if ($paginator->onFirstPage())
        <span class="px-4 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-300 rounded-lg cursor-not-allowed">
            ← Sebelumnya
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
            ← Sebelumnya
        </a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-4 py-2 text-sm text-slate-500">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-lg">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
            Berikutnya →
        </a>
    @else
        <span class="px-4 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-300 rounded-lg cursor-not-allowed">
            Berikutnya →
        </span>
    @endif
</nav>