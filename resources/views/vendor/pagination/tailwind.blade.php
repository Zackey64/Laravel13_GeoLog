@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">



        <div class="flex justify-center sm:justify-between flex-1 gap-2 items-center">

            <div class="hidden sm:block">
                <p class="text-sm text-gray-600 leading-5 dark:text-gray-600">
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('件中') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('～') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('件表示') !!}

                </p>
            </div>


            <div class="flex gap-1">

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="rounded-full px-3 py-1 text-sm font-bold text-gray-300">
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
                                    'bg-main text-white' => $page === $paginator->currentPage(),
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
                        <span class="rounded-full px-3 py-1 text-sm font-bold text-gray-300">
                            ＞
                        </span>
                    @endif

            </div>
        </div>
    </nav>
@endif
