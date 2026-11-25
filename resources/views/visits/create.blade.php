
<x-layouts.app title="来訪記録作成">
    <div>

        {{-- ページタイトル --}}
        <x-page-header
            title="来訪記録作成"
            description="新しい来訪記録を作成できます。"
        />
        
    {{-- 戻るボタン --}}
    <x-back-button
        :url="route('visits.index')"
        :label="'一覧へ戻る'"
    />



            {{-- 新規作成フォーム --}}
            <form action="{{ route('visits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-2 p-4 rounded-lg border border-gray-300">

                {{-- 写真 --}}
                <x-form.file
                    name="image_path"
                    label="写真を選択（任意）"
                />
                {{-- 内容 --}}
                <x-form.input
                    name="context"
                    label="来訪内容（任意）"
                    placeholder="来訪内容を入力"
                    :value="old('context')"
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
                        :value="old('station_id')"
                        placeholder="未選択"
                    />
                    <x-form.select
                        name="city_id"
                        label="市町村"
                        :options="$cities"
                        :value="old('city_id')"
                        placeholder="未選択"
                    />
                    </div>
                </div>
                </div>
                
                <div class="pt-2 flex gap-2 items-end justify-end">
                    {{-- 保存ボタン --}}
                    <x-form.button type="submit" color="primary">
                        記録を作成
                    </x-form.button>
                </div>

                
            </form>

    </div>
</x-layouts.app>
