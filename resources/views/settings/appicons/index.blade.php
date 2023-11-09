<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Manage Dashboard Icons
                    </h2>

                    <x-messages />

                    <form class="relative overflow-x-auto shadow-md sm:rounded-lg"
                          action="{{ route('settings.appicons.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 text-right">
                            <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    :class="{'bg-blue': changed, 'bg-cyan-100': !changed}" :disabled="!changed">
                                Update
                            </button>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900">
                            <div class="m-3">
                                <img :src="play_icon" alt="Play Icon"
                                     class="w-96 mb-5" />
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full px-3">
                                        <label for="play_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Play Icon
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('play_icon'),
                                                   "border-red-500" => $errors->first('play_icon'),
                                               ])
                                               type="file" id="play_icon" name="play_icon"
                                               accept="image/*"
                                               v-on:change="selectPlayIcon"
                                               placeholder="Choose Image...">
                                        @error('play_icon')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="m-3">
                                <img :src="improve_icon" alt="Improve Icon"
                                     class="w-96 mb-5" />
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full px-3">
                                        <label for="improve_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Improve Icon
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('improve_icon'),
                                                   "border-red-500" => $errors->first('improve_icon'),
                                               ])
                                               type="file" id="improve_icon" name="improve_icon"
                                               accept="image/*"
                                               v-on:change="selectImproveIcon"
                                               placeholder="Choose Image...">
                                        @error('improve_icon')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="m-3">
                                <img :src="rent_icon" alt="Rent Icon"
                                     class="w-96 mb-5" />
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full px-3">
                                        <label for="rent_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Rent Icon
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('rent_icon'),
                                                   "border-red-500" => $errors->first('rent_icon'),
                                               ])
                                               type="file" id="rent_icon" name="rent_icon"
                                               accept="image/*"
                                               v-on:change="selectRentIcon"
                                               placeholder="Choose Image...">
                                        @error('rent_icon')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="m-3">
                                <img :src="shop_icon" alt="Shop Icon"
                                     class="w-96 mb-5" />
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full px-3">
                                        <label for="shop_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Shop Icon
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('shop_icon'),
                                                   "border-red-500" => $errors->first('shop_icon'),
                                               ])
                                               type="file" id="shop_icon" name="shop_icon"
                                               accept="image/*"
                                               v-on:change="selectShopIcon"
                                               placeholder="Choose Image...">
                                        @error('shop_icon')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push ('scripts')
        <script type="module">
            const { createApp, ref, computed } = Vue;

            createApp({
                setup() {
                    const original_play_icon = '{{ $appicons['play'] }}';
                    const original_improve_icon = '{{ $appicons['improve'] }}';
                    const original_rent_icon = '{{ $appicons['rent'] }}';
                    const original_shop_icon = '{{ $appicons['shop'] }}';
                    const play_icon = ref(original_play_icon);
                    const improve_icon = ref(original_improve_icon);
                    const rent_icon = ref(original_rent_icon);
                    const shop_icon = ref(original_shop_icon);

                    const changed = computed(() => {
                        return play_icon.value !== original_play_icon
                            || improve_icon.value !== original_improve_icon
                            || rent_icon.value !== original_rent_icon
                            || shop_icon.value !== original_shop_icon;
                    });

                    const selectPlayIcon = e => {
                        const files = e.target.files;
                        if (!files.length) {
                            play_icon.value = original_play_icon;
                            return;
                        }
                        const fr = new FileReader();
                        fr.onload = () => play_icon.value = fr.result;
                        fr.readAsDataURL(files[0]);
                    }

                    const selectImproveIcon = e => {
                        const files = e.target.files;
                        if (!files.length) {
                            improve_icon.value = original_improve_icon;
                            return;
                        }
                        const fr = new FileReader();
                        fr.onload = () => improve_icon.value = fr.result;
                        fr.readAsDataURL(files[0]);
                    }

                    const selectRentIcon = e => {
                        const files = e.target.files;
                        if (!files.length) {
                            rent_icon.value = original_rent_icon;
                            return;
                        }
                        const fr = new FileReader();
                        fr.onload = () => rent_icon.value = fr.result;
                        fr.readAsDataURL(files[0]);
                    }

                    const selectShopIcon = e => {
                        const files = e.target.files;
                        if (!files.length) {
                            shop_icon.value = original_shop_icon;
                            return;
                        }
                        const fr = new FileReader();
                        fr.onload = () => shop_icon.value = fr.result;
                        fr.readAsDataURL(files[0]);
                    }

                    return {
                        changed,
                        play_icon, selectPlayIcon,
                        improve_icon, selectImproveIcon,
                        rent_icon, selectRentIcon,
                        shop_icon, selectShopIcon
                    }
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
