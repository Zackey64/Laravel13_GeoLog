
<x-layouts.app title="来訪記録一覧">
    <div>

        {{-- ページタイトル --}}
        <x-page-header
            title="来訪記録一覧"
            description="来訪記録の一覧を確認できます。"
        />

        {{-- フィルターセクション --}}
        <div class="p-4 grid md:grid-cols-2 gap-2 rounded-xl border border-gray-300 bg-white">

            {{-- 都道府県フィルター --}}
            <form action="{{ route('visits.index') }}" method="GET">
                <input type="hidden" name="prefecture_id" value="{{ request('prefecture_id') }}">
                <input type="hidden" name="sort" value="{{ request('sort', 'code') }}">

                <div class="flex items-end gap-2">

                    <div class="flex-1">
                        <x-form.input
                            name="keyword"
                            label="キーワード検索"
                            placeholder="内容で検索"
                        />
                    </div>

                    <x-form.button>
                        検索
                    </x-form.button>

                    <x-form.button
                        type="button"
                        color="secondary"
                        :onclick="'location.href=\''.route('visits.index').'\''"
                    >
                        リセット
                    </x-form.button>

                </div>
            </form>

            {{--フィルタ＋ソート --}}
            <form action="{{ route('visits.index') }}" method="GET">
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">

                <div class="grid gap-2 grid-cols-2">

                    <x-form.select
                    name="prefecture_id"
                    label="都道府県"
                    :options="$prefectures"
                    :value="request('prefecture_id')"
                    onchange="this.form.submit()"
                    />

                    <x-form.select
                    name="sort"
                    label="並び替え"
                    :options="[
                        (object) ['id' => 'updated_at', 'name' => '新しい順'],
                    ]"
                    :value="request('sort', 'updated_at')"
                    onchange="this.form.submit()"
                    />

                </div>
            </form>
        </div>


        

        {{-- 本体 --}}
        <x-tabs.index default="list">

            {{-- タブ切り替えボタン＋ 登録件数 --}}
            <div class="my-2 flex items-center justify-between">
                <x-form.button type="button" color="primary" onclick="location.href='{{ route('visits.create') }}'">
                    新規作成
                </x-form.button>   
                <p class="font-bold text-md text-main">
                    全 {{ $visits->total() }} 件
                </p>
            </div>
        



                {{-- ページネーション --}}
                <div class="my-2">
                    {{ $visits->links() }}
                </div>
                {{-- カード一覧 --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @forelse ($visits as $visit)
                        <x-visit-card :visit="$visit" />
                    @empty
                        <p class="col-span-full py-12 text-center text-gray-500">
                            来訪記録が登録されていません。
                        </p>
                    @endforelse
                </div>


        </x-tabs.index>

</x-layouts.app>
