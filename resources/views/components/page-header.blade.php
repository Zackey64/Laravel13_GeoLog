@props([
    'title',
    'description' => null,
])

<div class="my-4 px-4 py-2 bg-main-soft rounded-lg">
    <h1 class="text-2xl font-bold tracking-tight text-main">
        {{ $title }}
    </h1>

    @if ($description)
        <p class="mt-2 text-sm text-gray-500">
            {{ $description }}
        </p>
    @endif
</div>