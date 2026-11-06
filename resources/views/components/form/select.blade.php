@props([
    'name',
    'label',
    'options',
    'value' => null,
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'placeholder' => 'すべて',
])

<div>
    <label for="{{ $name }}"
        class="mb-1 block text-xs  text-gray-600">
        {{ $label }}
    </label>

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 rounded-lg border border-gray-300 text-sm'
        ]) }}
    >
        <option value="">{{ $placeholder }}</option>

        @foreach ($options as $option)
            <option
                value="{{ data_get($option, $optionValue) }}"
                @selected(
                    (string) old($name, $value ?? request($name)) === (string) data_get($option, $optionValue)
                )
            >
                {{ data_get($option, $optionLabel) }}
            </option>
        @endforeach
    </select>
</div>