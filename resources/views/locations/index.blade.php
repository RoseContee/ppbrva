<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Locations
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900">
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input class="block p-2 pl-10 text-sm text-gray-900 border border-slate-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       type="text"
                                       placeholder="Search by name..."
                                       v-model="keyword">
                            </div>
                            <a class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                               href="{{ route('locations.create') }}">
                                + Add Location
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700 sm:max-w-sm m-6"
                            v-for="(location, index) in filteredLocations" key="index">
                            <a :href="'{{ route('locations.index') }}/' + location.id + '/edit'">
                                <img class="rounded-t-lg" alt="Image"
                                     :src="location.image"/>
                            </a>
                            <div class="p-6">
                                <h5 class="mb-2 text-xl font-medium leading-tight text-neutral-800 dark:text-neutral-50">
                                    <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                       :href="'{{ route('locations.index') }}/' + location.id + '/edit'"
                                       v-text="location.name"></a>
                                </h5>
                                <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200"
                                   v-text="location.address"></p>
                                <a class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                   :href="'{{ route('locations.index') }}/' + location.id + '/edit'">
                                    Manage
                                </a>
                            </div>
                        </div>
                        <div class="m-6 italic" v-if="!filteredLocations.length">
                            No locations found.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            const { createApp, ref, computed } = Vue

            createApp({
                setup() {
                    const locations = {!! $locations !!};
                    const keyword = ref('');
                    const filteredLocations = computed(() => {
                        return locations.filter(item => {
                            return item.name.toLowerCase().indexOf(keyword.value.toLowerCase()) !== -1;
                        });
                    });
                    return {
                        keyword,
                        filteredLocations,
                    }
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
