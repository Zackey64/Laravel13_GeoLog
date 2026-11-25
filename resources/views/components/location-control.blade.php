
<div class="p-1 flex justify-between rounded-lg overflow-hidden border border-gray-300 bg-white"
    x-data="{
        location: null,
        loading: false,
        error: '',

        init() {
            this.location = window.GeolocationService.getSavedPosition();
        },

        async updateLocation() {
            this.loading = true;
            this.error = '';

            try {
                this.location = await window.GeolocationService.updatePosition();

                window.dispatchEvent(new Event('location-updated'));
            } catch (error) {
                this.error = '位置情報を取得できませんでした。';
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    }"
>
    <div class="flex px-2 items-center gap-2 text-sm">

        <template x-if="location">
            <span x-text="location.address ?? '位置情報取得済'"></span>
        </template>

        <template x-if="!location">
            <span>位置情報未取得</span>
        </template>
    </div>

    <button
    class="px-3 text-sm font-bold text-white bg-main rounded-full"
        type="button"
        @click="updateLocation()"
        :disabled="loading"
        class="disabled:opacity-50"
        x-text="loading ? '取得中...' : (location ? '更新' : '取得')"
    ></button>

    <span x-show="error" x-text="error" class="text-red-600"></span>
</div>
