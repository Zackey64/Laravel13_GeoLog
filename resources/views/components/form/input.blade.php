@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
])

<div>
    <label for="{{ $name }}"
        class="mb-1 block text-xs  text-gray-600">
        {{ $label }}
    </label>

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value ?? request($name)) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'w-full px-3 py-1 rounded-lg border border-gray-300 text-sm'
        ]) }}
    >
    {{-- エラー --}}
    @error($name)
        <p class="mt-1 text-xs text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>