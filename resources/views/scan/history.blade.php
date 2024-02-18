<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Scans
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-4">
                        <div class="flex items-center p-4 bg-white dark:bg-gray-900">
                            <div class="relative mr-2">
                                <button class="inline-flex items-center text-gray-500 bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        v-on:click="toggleFilter">
                                    <span v-text="'Filter: ' + filterText"></span>
                                    <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <div class="absolute hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                                     :style="{display: showFilter ? 'block' : 'none'}">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                               href="javascript:void(0);"
                                               :class="{'bg-zinc-100': filter === 'all'}"
                                               v-on:click="filter = 'all'; showFilter = false;">
                                                All
                                            </a>
                                        </li>
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                               href="javascript:void(0);"
                                               :class="{'bg-zinc-100': filter === 'newest'}"
                                               v-on:click="filter = 'newest'; showFilter = false;">
                                                Newest First
                                            </a>
                                        </li>
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                               href="javascript:void(0);"
                                               :class="{'bg-zinc-100': filter === 'oldest'}"
                                               v-on:click="filter = 'oldest'; showFilter = false;">
                                                Oldest First
                                            </a>
                                        </li>
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                               href="javascript:void(0);"
                                               :class="{'bg-zinc-100': filter === 'location'}"
                                               v-on:click="filter = 'location'; showFilter = false;">
                                                Location
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="relative hidden mr-2"
                                 :style="{display: filter === 'location' ? 'block' : 'none'}">
                                <button class="inline-flex items-center text-gray-500 bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        v-on:click="toggleLocationFilter">
                                    <span v-text="'Location: ' + locationFilterText"></span>
                                    <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <div class="absolute hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                                     :style="{display: showLocationFilter ? 'block' : 'none'}">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                        @foreach ($locations as $location)
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': locationFilter === '{{ $location['id'] }}'}"
                                                   v-on:click="locationFilter = '{{ $location['id'] }}'; showLocationFilter = false;">
                                                    {{ $location['name'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input class="block p-2 pl-10 text-sm text-gray-900 border border-slate-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           type="text"
                                           placeholder="Search by keyword..."
                                           v-model="keyword">
                                </div>
                            </div>
                        </div>

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-zinc-100 text-navy">
                                    <th scope="col" class="px-6 py-3">Member</th>
                                    <th scope="col" class="px-6 py-3">Timestamp</th>
                                    <th scope="col" class="px-6 py-3">Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="(scan, index) in pageScans" key="index">
                                    <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <img class="w-10 h-10 rounded-full" :src="scan.member.avatar" :alt="scan.member.name">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">
                                                <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                                   :href="'{{ route('members.index') }}/' + scan.member.id + '/edit'"
                                                   v-text="scan.member.name"></a>
                                            </div>
                                            <div class="font-normal text-gray-500" v-text="'#' + scan.member.memberID"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" v-text="scan.timestamp"></td>
                                    <td class="px-6 py-4" v-text="scan.location.name"></td>
                                </tr>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-if="!pageScans.length">
                                    <td class="px-6 py-4 italic" colspan="3">
                                        No scans found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <nav class="flex items-center justify-between text-sm p-4"
                             v-if="filteredScans.length">
                            <span v-text="paginationInfo"></span>
                            <ul class="flex -space-x-px h-8">
                                <li>
                                    <a class="flex items-center justify-center bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-gray-200 font-medium rounded-l-lg text-sm px-3 h-8 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 text-gray-500"
                                       :class="{'cursor-not-allowed': isFirstPage}"
                                       v-on:click="prevPage">
                                        <span class="sr-only">Previous</span>
                                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center justify-center bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-gray-200 font-medium rounded-r-lg text-sm px-3 h-8 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 text-gray-500"
                                       :class="{'cursor-not-allowed': isLastPage}"
                                       v-on:click="nextPage">
                                        <span class="sr-only">Next</span>
                                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            const { createApp, ref, computed, watch } = Vue;

            createApp({
                setup() {
                    const scans = ref({!! $scans !!});
                    const keyword = ref('');
                    const filter = ref('all');
                    const locationFilter = ref('{{ $locations[0]['id'] ?? '' }}');
                    const filteredScans = computed(() => {
                        return scans.value.filter(scan => {
                            const q = keyword.value.toLowerCase();
                            return (scan.member.name.toLowerCase().includes(q)
                                || scan.member.memberID.toLowerCase().includes(q)
                                || scan.timestamp.toLowerCase().includes(q)
                                || scan.location.name.toLowerCase().includes(q)
                            ) && (['all', 'newest', 'oldest'].includes(filter.value)
                                || (filter.value === 'location' && scan.location_id == locationFilter.value)
                            );
                        }).sort((a, b) => {
                            if (filter.value === 'newest') {
                                return b.created_at.localeCompare(a.created_at);
                            }
                            if (filter.value === 'oldest') {
                                return a.created_at.localeCompare(b.created_at);
                            }
                            return a.id - b.id;
                        });
                    });
                    const per_page = 50;
                    const page = ref(1);
                    watch(keyword, () => page.value = 1);
                    watch(filter, () => {
                        if (filter.value === 'location') page.value = 1;
                    });
                    watch(locationFilter, () => page.value = 1);
                    const pageScans = computed(() => {
                        return filteredScans.value.filter((scan, index) => {
                            return (page.value - 1) * per_page <= index
                                && index < Math.min(page.value * per_page, filteredScans.value.length);
                        });
                    });
                    const showFilter = ref(false);
                    const toggleFilter = () => {
                        showFilter.value = !showFilter.value;
                    }
                    const filterText = computed(() => {
                        if (filter.value === 'newest') return 'Newest First';
                        if (filter.value === 'oldest') return 'Oldest First';
                        if (filter.value === 'location') return 'Location';
                        return 'All';
                    });
                    const showLocationFilter = ref(false);
                    const toggleLocationFilter = () => {
                        showLocationFilter.value = !showLocationFilter.value;
                    }
                    const locationFilterText = computed(() => {
                        const locations = {{ Js::from($locations) }};
                        return locations.find(location => location.id == locationFilter.value)?.name;
                    });
                    const paginationInfo = computed(() => {
                        const total = filteredScans.value.length;
                        const from = (page.value - 1) * per_page + 1;
                        const to = Math.min(page.value * per_page, total);
                        return `From ${from} to ${to} of ${total} invoices`;
                    });
                    const isFirstPage = computed(() => {
                        return page.value === 1;
                    });
                    const prevPage = () => {
                        if (!isFirstPage.value) page.value--;
                    }
                    const isLastPage = computed(() => {
                        return page.value * per_page >= filteredScans.value.length;
                    });
                    const nextPage = () => {
                        if (!isLastPage.value) page.value++;
                    }

                    return {
                        keyword, filter, locationFilter, filteredScans, pageScans,
                        showFilter, toggleFilter, filterText,
                        showLocationFilter, toggleLocationFilter, locationFilterText,
                        paginationInfo, isFirstPage, prevPage, isLastPage, nextPage,
                    }
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
