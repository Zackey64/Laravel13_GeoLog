<x-layouts.app title="来訪記録:">

@php
    $station = $visit->station;
    $city = $visit->city;

    $destination = match (true) {
        $station !== null => route('stations.show', $station),
        $city !== null => route('cities.show', $city),
        default => null,
    };

    $connected = match (true) {
        $station !== null => "道の駅 ".$station->name,
        $city !== null => "市町村 ".$city->name,
        default => null,
    };
@endphp

    {{-- ページタイトル --}}
    <x-page-header
        title="来訪記録"
        description="{{ $connected }} に紐づいている来訪記録"
    />

    {{-- 戻るボタン --}}
    <x-back-button
        :url="route('visits.index')"
        :label="'一覧へ戻る'"
    />

    {{-- 詳細情報 --}}
    
    <div class="grid gap-4 md:grid-cols-2">

        <div class="w-full overflow-hidden rounded-lg border border-gray-300 bg-gray-600">
            <img
                src="{{ asset('storage/' . $visit->image_path) }}"
                alt="{{ $visit->context }}"
                class="aspect-square w-full h-full object-contain"
            />
        </div>

        

        <div class="flex flex-col gap-4">
            {{--情報 --}}
            <div class="flex flex-col p-4 rounded-lg border border-gray-300">
                <p class="text-main font-bold">
                    記録情報
                </p>
                <div class="justify-between flex border-b border-gray-300 py-1">

                    <p class="text-gray-600 text-sm font-bold">
                        {{ $visit->context ?? '未記入' }}
                    </p>
                </div>
                <div class="justify-between flex border-b border-gray-300 py-1">
                    <p class="text-gray-600 text-sm">
                    来訪日時
                    </p>
                    <p class="text-gray-600 text-sm font-bold">
                        {{ $visit->updated_at->format('Y/m/d') ?? '未記入' }}
                    </p>
                </div>
                <a href="{{ $destination ?? '#' }}" class="justify-between flex border-b border-gray-300 py-1">
                    <p class="text-gray-600 text-sm">
                    紐付先
                    </p>
                    <p class="text-gray-600 text-sm font-bold">
                        {{ $connected ?? '未記入' }}
                    </p>
                </a>
            </div>


            {{--編集フォーム --}}
            <form action="{{ route('visits.update', $visit) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-2 p-4 rounded-lg border border-gray-300">
                <p class="text-main font-bold">
                    記録編集フォーム
                </p>
                {{-- 写真 --}}
                <x-form.file
                    name="image_path"
                    label="写真を変更（任意）"
                />
                {{-- 内容 --}}
                <x-form.input
                    name="context"
                    label="来訪内容（任意）"
                    placeholder="来訪内容を入力"
                    :value="old('context', $visit->context)"
                />
                {{-- 紐付先選択 --}}
                <div>
                    <label class="text-gray-600 text-xs block mb-1">
                        紐付先を選択（どちらか１つ選択）
                    </label>

                    <div class="rounded-lg border border-gray-300 p-2 grid gap-2 grid-cols-2">
                    <x-form.select
                        name="station_id"
                        label="道の駅"
                        :options="$stations"
                        :value="$visit->station_id"
                        placeholder="未選択"
                    />
                    <x-form.select
                        name="city_id"
                        label="市町村"
                        :options="$cities"
                        :value="$visit->city_id"
                        placeholder="未選択"
                    />
                    </div>
                </div>
                
                
                <div class="pt-2 flex gap-2 items-end justify-end">
                    {{-- 削除ボタン --}}
                    <x-form.button type="submit" color="danger" form="delete-visit-form">
                        記録を削除
                    </x-form.button>                    
                    {{-- 保存ボタン --}}
                    <x-form.button type="submit" color="primary">
                        記録を更新
                    </x-form.button>
                </div>
                </div>
                
            </form>

        <form
            id="delete-visit-form"
            action="{{ route('visits.destroy', $visit) }}"
            method="POST"
            onsubmit="return confirm('本当に削除しますか？')"
            hidden
        >
            @csrf
            @method('DELETE')
        </form>

        </div>
    </div>

</x-layouts.app>