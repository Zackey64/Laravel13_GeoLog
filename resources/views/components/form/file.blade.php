@props([
    'name',
    'label' => '写真を選択',
    'accept' => 'image/*',
])

<div data-file-field>
    <p class="mb-1 text-xs text-gray-600">{{ $label }}</p>

    <input
        type="file"
        name="{{ $name }}"
        accept="{{ $accept }}"
        hidden
        onchange="this.closest('[data-file-field]').querySelector('[data-file-name]').textContent = this.files[0]?.name ?? 'ファイル未選択'"
    >

    <div class="flex items-center gap-2">
        <span
            data-file-name
            aria-live="polite"
            class="min-w-0 flex-1 break-all rounded-lg border border-gray-300 px-3 py-1 text-sm text-gray-600"
        >
            ファイル未選択
        </span>

        <button
            type="button"
            class="shrink-0 rounded-lg bg-main px-3 py-1 text-sm font-bold text-white"
            onclick="this.closest('[data-file-field]').querySelector('input[type=file]').click()"
        >
            写真を選択
        </button>
    </div>

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>