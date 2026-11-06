@props(['name', 'label'])

<button
    type="button"
    @click="tab = '{{ $name }}'"
    :class="tab === '{{ $name }}'
        ? 'border-blue-600 text-blue-600'
        : 'border-transparent text-gray-400'"
    class="border-b-2 px-6 py-2 text-md font-bold"
>
    {{ $label }}
</button>