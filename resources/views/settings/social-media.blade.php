<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                Social Media
            </h2>

            <x-messages />

            <form class="relative overflow-x-auto shadow-md sm:rounded-lg"
                  action="{{ route('settings.social-media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4 text-right">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            :class="{'bg-blue': changed, 'bg-cyan-100': !changed}" :disabled="!changed">
                        Update
                    </button>
                </div>
                <div class="flex p-4 bg-white dark:bg-gray-900">
                    <div class="w-full p-2">
                        <img :src="social1_icon" alt="Social Icon" class="w-full mb-5" />
                        <div class="w-full mb-4">
                            <label for="social1_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Social 1 Icon
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('social1_icon'),
                                       "border-red-500" => $errors->first('social1_icon'),
                                   ])
                                   type="file" id="social1_icon" name="social1_icon" accept="image/*"
                                   v-on:change="selectSocial1Icon"
                                   placeholder="Choose Image...">
                            @error('social1_icon')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="social1_link" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Social 1 Link
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('social1_link'),
                                       "border-red-500" => $errors->first('social1_link'),
                                   ])
                                   type="url" id="social1_link" name="social1_link" required
                                   v-model="social1_link"
                                   placeholder="Social Link...">
                            @error('social1_link')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full p-2">
                        <img :src="social2_icon" alt="Social Icon" class="w-full mb-5" />
                        <div class="w-full mb-4">
                            <label for="social2_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Social 2 Icon
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('social2_icon'),
                                       "border-red-500" => $errors->first('social2_icon'),
                                   ])
                                   type="file" id="social2_icon" name="social2_icon" accept="image/*"
                                   v-on:change="selectSocial2Icon"
                                   placeholder="Choose Image...">
                            @error('social2_icon')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="social2_link" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Social 2 Link
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('social2_link'),
                                       "border-red-500" => $errors->first('social2_link'),
                                   ])
                                   type="url" id="social2_link" name="social2_link" required
                                   v-model="social2_link"
                                   placeholder="Social Link...">
                            @error('social2_link')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full p-2">
                        <img :src="social3_icon" alt="Rent Icon" class="w-full mb-5" />
                        <div class="w-full mb-4">
                            <label for="social3_icon" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Social 3 Icon
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('social3_icon'),
                                       "border-red-500" => $errors->first('social3_icon'),
                                   ])
                                   type="file" id="social3_icon" name="social3_icon" accept="image/*"
                                   v-on:change="selectSocial3Icon"
                                   placeholder="Choose Image...">
                            @error('social3_icon')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="social3_link" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Social 3 Link
                            </label>
                            <input @class([
                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                       "border-slate-300" => !$errors->first('social3_link'),
                                       "border-red-500" => $errors->first('social3_link'),
                                   ])
                                   type="url" id="social3_link" name="social3_link" required
                                   v-model="social3_link"
                                   placeholder="Social Link...">
                            @error('social3_link')
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
                    const original_social1_icon = '{{ $settings['social1_icon'] }}';
                    const original_social1_link = '{{ $settings['social1_link'] }}';
                    const original_social2_icon = '{{ $settings['social2_icon'] }}';
                    const original_social2_link = '{{ $settings['social2_link'] }}';
                    const original_social3_icon = '{{ $settings['social3_icon'] }}';
                    const original_social3_link = '{{ $settings['social3_link'] }}';
                    const social1_icon = ref(original_social1_icon);
                    const selectSocial1Icon = e => {
                        const files = e.target.files;
                        if (!files.length) {
                            social1_icon.value = original_social1_icon;
                            return;
                        }
                        const fr = new FileReader();
                        fr.onload = () => social1_icon.value = fr.result;
                        fr.readAsDataURL(files[0]);
                    }
                    const social1_link = ref(original_social1_link);
                    const social2_icon = ref(original_social2_icon);
                    const selectSocial2Icon = e => {
                        const files = e.target.files;
                        if (!files.length) {
                            social2_icon.value = original_social2_icon;
                            return;
                        }
                        const fr = new FileReader();
                        fr.onload = () => social2_icon.value = fr.result;
                        fr.readAsDataURL(files[0]);
                    }
                    const social2_link = ref(original_social2_link);
                    const social3_icon = ref(original_social3_icon);
                    const selectSocial3Icon = e => {
                        const files = e.target.files;
                        if (!files.length) {
                            social3_icon.value = original_social3_icon;
                            return;
                        }
                        const fr = new FileReader();
                        fr.onload = () => social3_icon.value = fr.result;
                        fr.readAsDataURL(files[0]);
                    }
                    const social3_link = ref(original_social3_link);

                    const changed = computed(() => {
                        return social1_icon.value !== original_social1_icon
                            || social1_link.value !== original_social1_link
                            || social2_icon.value !== original_social2_icon
                            || social2_link.value !== original_social2_link
                            || social3_icon.value !== original_social3_icon
                            || social3_link.value !== original_social3_link;
                    });

                    return {
                        changed,
                        social1_icon, selectSocial1Icon, social1_link,
                        social2_icon, selectSocial2Icon, social2_link,
                        social3_icon, selectSocial3Icon, social3_link,
                    }
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
