@props([
    'name',
    'label',
    'value' => null,
    'placeholder' => '',
])

<div>
    <label for="{{ $name }}"
        class="mb-1 block text-xs  text-gray-600">
        {{ $label }}
    </label>

    <input
        type="text"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value ?? request($name)) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 rounded-lg border border-gray-300 text-sm'
        ]) }}
    >
</div>