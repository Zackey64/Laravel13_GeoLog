@props([
    'url' => null,
    'label' => '戻る',
])

<a href="{{ $url ?? url()->previous() }}"
   class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-green-700">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-4 w-4"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="2">
        <path stroke-linecap="round"
              stroke-linejoin="round"
              d="M15 19l-7-7 7-7" />
    </svg>

    {{ $label }}
</a>