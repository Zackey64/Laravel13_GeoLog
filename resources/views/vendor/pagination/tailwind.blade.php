@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">



        <div class="flex justify-center sm:justify-between flex-1 gap-2 items-center">

            <div class="hidden sm:block">
                <p class="text-sm text-gray-700 leading-5 dark:text-gray-600">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>


            <div class="flex gap-1">

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="rounded-full px-3 py-1 text-sm text-gray-300">
                            ＜
                        </span>
                    @else
                        <a
                            href="{{ $paginator->previousPageUrl() }}"
                            class="rounded-full px-3 py-1 text-sm font-bold text-gray-600 bg-white"
                        >
                            ＜
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <a
                                    href="{{ $url }}"
                                    @class([
                                    'rounded-full px-3 py-1 text-sm font-bold transition',
                                    'bg-blue-600 text-white' => $page === $paginator->currentPage(),
                                    'text-gray-600 bg-white' => $page !== $paginator->currentPage(),
                                    ])
                                >
                                    {{ $page }}
                                </a>
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a
                            href="{{ $paginator->nextPageUrl() }}"
                            class="rounded-full px-3 py-1 text-sm font-bold text-gray-600 bg-white"
                        >
                            ＞
                        </a>
                    @else
                        <span class="rounded-full px-3 py-1 text-sm text-gray-300">
                            ＞
                        </span>
                    @endif

            </div>
        </div>
    </nav>
@endif
