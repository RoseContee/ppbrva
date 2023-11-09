@php
$add = empty($location);
$route = $add ? route('locations.store') : route('locations.update', $location['id']);
@endphp

<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ $add ? 'Add' : 'Edit' }} Location
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <form class="flex items-center justify-between p-4 bg-white dark:bg-gray-900"
                              action="{{ $route }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (!$add)
                                @method('PUT')
                            @endif
                            <div class="w-full max-w-lg">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="name" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Location Name
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('name'),
                                                   "border-red-500" => $errors->first('name'),
                                               ])
                                               type="text" id="name" name="name" required
                                               value="{{ old('name', $location['name'] ?? '') }}"
                                               placeholder="Location Name...">
                                        @error('name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="address" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Address
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('address') && !$errors->first('lat') && !$errors->first('lng'),
                                                   "border-red-500" => $errors->first('address') || $errors->first('lat') || $errors->first('lng'),
                                               ])
                                               type="text" id="address" autocomplete="off"
                                               value="{{ old('address', $location['address'] ?? '') }}"
                                               placeholder="Address...">
                                        @if ($errors->first('address') || $errors->first('lat') || $errors->first('lng'))
                                        <p class="text-red-500 text-xs italic">The address field is required.</p>
                                        @endif
                                        <p class="text-gray-600 text-xs italic mb-2">Enter address and choose the correct result</p>
                                        <p class="text-gray-600 text-xs italic">Address: <span v-text="address"></span></p>
                                        <p class="text-gray-600 text-xs italic">Latitude: <span v-text="lat"></span></p>
                                        <p class="text-gray-600 text-xs italic">Longitude: <span v-text="lng"></span></p>
                                        <input type="hidden" name="address" v-model="address">
                                        <input type="hidden" name="lat" v-model="lat">
                                        <input type="hidden" name="lng" v-model="lng">
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="phone" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Phone
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('phone'),
                                                   "border-red-500" => $errors->first('phone'),
                                               ])
                                               type="text" id="phone" name="phone" required
                                               value="{{ old('phone', $location['phone'] ?? '') }}"
                                               placeholder="Phone...">
                                        @error('phone')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="email" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Email
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('email'),
                                                   "border-red-500" => $errors->first('email'),
                                               ])
                                               type="email" id="email" name="email" required
                                               value="{{ old('email', $location['email'] ?? '') }}"
                                               placeholder="Email...">
                                        @error('email')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="website" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Website
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('website'),
                                                   "border-red-500" => $errors->first('website'),
                                               ])
                                               type="url" id="website" name="website" required
                                               value="{{ old('website', $location['website'] ?? '') }}"
                                               placeholder="Website...">
                                        @error('website')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        :class="{'bg-blue': submitEnabled, 'bg-cyan-100': !submitEnabled}"
                                        type="submit" :disabled="!submitEnabled">
                                    {{ $add ? '+ Add' : 'Update' }} Location
                                </button>
                            </div>

                            <div class="w-full max-w-lg">
                                <div class="justify-center" :class="{'flex': image, 'hidden': !image}">
                                    <img :src="image" alt="Image"
                                         class="w-96 mb-5" />
                                </div>
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="image" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Upload Image
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('image'),
                                                   "border-red-500" => $errors->first('image'),
                                               ])
                                               type="file" id="image" name="image" @required($add)
                                               accept="image/*"
                                               v-on:change="selectImage"
                                               placeholder="Choose Image...">
                                        @error('image')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_KEY') }}&libraries=places" defer></script>
        <script type="module" defer>
            const { createApp, ref, computed } = Vue;
            let autocomplete;

            createApp({
                setup() {
                    const address = ref('{{ old('address', $location['address'] ?? '') }}');
                    const lat = ref('{{ old('lat', $location['lat'] ?? '') }}');
                    const lng = ref('{{ old('lng', $location['lng'] ?? '') }}');
                    const selectAddress = () => {
                        const place = autocomplete.getPlace();
                        address.value = place.formatted_address;
                        const location = place.geometry.location;
                        lat.value = location.lat();
                        lng.value = location.lng();
                    }

                    const submitEnabled = computed(() => lat.value && lng.value);

                    const original_image = '{{ $add ? '' : asset($location['image']) }}';
                    const image = ref(original_image);
                    const selectImage = (e) => {
                        const files = e.target.files;
                        if (!files.length) {
                            image.value = original_image;
                            return;
                        }
                        const fr = new FileReader();
                        fr.onload = () => {
                            image.value = fr.result;
                        };
                        fr.readAsDataURL(files[0]);
                    }

                    return {
                        address, lat, lng, selectAddress, submitEnabled,
                        image, selectImage
                    }
                },
                mounted() {
                    autocomplete = new google.maps.places.Autocomplete(document.querySelector("#address"), {
                        componentRestrictions: {country: ['us']},
                        fields: ['address_components', 'formatted_address', 'geometry'],
                        types: ["address"],
                    });
                    autocomplete.addListener('place_changed', this.selectAddress);
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
