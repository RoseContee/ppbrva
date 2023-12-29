<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                App Dashboard Settings
            </h2>

            <x-messages />

            <form class="relative overflow-x-auto shadow-md sm:rounded-lg"
                  action="{{ route('settings.app-dashboard.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4 text-right">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            :class="{'bg-blue': changed, 'bg-cyan-100': !changed}" :disabled="!changed">
                        Update
                    </button>
                </div>
                <div class="flex p-4 bg-white dark:bg-gray-900">
                    <div class="w-full p-2">
                        <img :src="play_icon" alt="Play Icon" class="w-full mb-5" />
                        <div class="w-full mb-4">
                            <label for="play_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Play Icon
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('play_icon'),
                                       "border-red-500" => $errors->first('play_icon'),
                                   ])
                                   type="file" id="play_icon" name="play_icon" accept="image/*"
                                   v-on:change="selectPlayIcon"
                                   placeholder="Choose Image...">
                            @error('play_icon')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="play_link" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Play Link
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('play_link'),
                                       "border-red-500" => $errors->first('play_link'),
                                   ])
                                   type="url" id="play_link" name="play_link" required
                                   v-model="play_link"
                                   placeholder="Play Link...">
                            @error('play_link')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full p-2">
                        <img :src="improve_icon" alt="Improve Icon" class="w-full mb-5" />
                        <div class="w-full mb-4">
                            <label for="improve_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Improve Icon
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('improve_icon'),
                                       "border-red-500" => $errors->first('improve_icon'),
                                   ])
                                   type="file" id="improve_icon" name="improve_icon" accept="image/*"
                                   v-on:change="selectImproveIcon"
                                   placeholder="Choose Image...">
                            @error('improve_icon')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="improve_link" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Improve Link
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('improve_link'),
                                       "border-red-500" => $errors->first('improve_link'),
                                   ])
                                   type="url" id="improve_link" name="improve_link" required
                                   v-model="improve_link"
                                   placeholder="Improve Link...">
                            @error('improve_link')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full p-2">
                        <img :src="rent_icon" alt="Rent Icon" class="w-full mb-5" />
                        <div class="w-full mb-4">
                            <label for="rent_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Rent Icon
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('rent_icon'),
                                       "border-red-500" => $errors->first('rent_icon'),
                                   ])
                                   type="file" id="rent_icon" name="rent_icon" accept="image/*"
                                   v-on:change="selectRentIcon"
                                   placeholder="Choose Image...">
                            @error('rent_icon')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="rent_link" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Rent Link
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('rent_link'),
                                       "border-red-500" => $errors->first('rent_link'),
                                   ])
                                   type="url" id="rent_link" name="rent_link" required
                                   v-model="rent_link"
                                   placeholder="Rent Link...">
                            @error('rent_link')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full p-2">
                        <img :src="shop_icon" alt="Shop Icon" class="w-full mb-5" />
                        <div class="w-full mb-4">
                            <label for="shop_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Shop Icon
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('shop_icon'),
                                       "border-red-500" => $errors->first('shop_icon'),
                                   ])
                                   type="file" id="shop_icon" name="shop_icon" accept="image/*"
                                   v-on:change="selectShopIcon"
                                   placeholder="Choose Image...">
                            @error('shop_icon')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="shop_link" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Shop Link
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('shop_link'),
                                       "border-red-500" => $errors->first('shop_link'),
                                   ])
                                   type="url" id="shop_link" name="shop_link" required
                                   v-model="shop_link"
                                   placeholder="Shop Link...">
                            @error('shop_link')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push ('scripts')
        <script type="module">
            const { createApp, ref, computed } = Vue;

            createApp({
                setup() {
                    const original_play_icon = '{{ $settings['play_icon'] }}';
                    const original_play_link = '{{ $settings['play_link'] }}';
                    const original_improve_icon = '{{ $settings['improve_icon'] }}';
                    const original_improve_link = '{{ $settings['improve_link'] }}';
                    const original_rent_icon = '{{ $settings['rent_icon'] }}';
                    const original_rent_link = '{{ $settings['rent_link'] }}';
                    const original_shop_icon = '{{ $settings['shop_icon'] }}';
                    const original_shop_link = '{{ $settings['shop_link'] }}';
                    const play_icon = ref(original_play_icon);
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
                    const play_link = ref(original_play_link);
                    const improve_icon = ref(original_improve_icon);
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
                    const improve_link = ref(original_improve_link);
                    const rent_icon = ref(original_rent_icon);
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
                    const rent_link = ref(original_rent_link);
                    const shop_icon = ref(original_shop_icon);
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
                    const shop_link = ref(original_shop_link);

                    const changed = computed(() => {
                        return play_icon.value !== original_play_icon
                            || play_link.value !== original_play_link
                            || improve_icon.value !== original_improve_icon
                            || improve_link.value !== original_improve_link
                            || rent_icon.value !== original_rent_icon
                            || rent_link.value !== original_rent_link
                            || shop_icon.value !== original_shop_icon
                            || shop_link.value !== original_shop_link;
                    });

                    return {
                        changed,
                        play_icon, selectPlayIcon, play_link,
                        improve_icon, selectImproveIcon, improve_link,
                        rent_icon, selectRentIcon, rent_link,
                        shop_icon, selectShopIcon, shop_link,
                    }
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
