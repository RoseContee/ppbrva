<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Activity
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-4">
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
                                       placeholder="Search by keyword..."
                                       v-model="keyword">
                            </div>

                            <a class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                               href="{{ route('activity.create') }}">
                                + Add Activity
                            </a>
                        </div>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-zinc-100 text-navy">
                                    <th scope="col" class="px-6 py-3">Member</th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">Detail</th>
                                    <th scope="col" class="px-6 py-3">Amount</th>
                                    <th scope="col" class="px-6 py-3">Date</th>
                                    <th scope="col" class="px-6 py-3 items-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="(activity, index) in pageActivities" key="index">
                                    <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <img class="w-10 h-10 rounded-full" v-if="activity.member.avatar"
                                             :src="activity.member.avatar"
                                             :alt="activity.member.name">
                                        <div class="pl-3" v-if="activity.member.name">
                                            <div class="text-base font-semibold">
                                                <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                                   :href="'{{ route('members.index') }}/' + activity.member.id + '/edit'"
                                                   v-text="activity.member.name"></a>
                                            </div>
                                            <div class="font-normal text-gray-500"
                                                 v-text="'#' + activity.member.memberID"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" v-text="activity.category"></td>
                                    <td class="px-6 py-4" v-text="(activity.from === 'clover' ? '#' : '') + activity.detail"></td>
                                    <td class="px-6 py-4" v-text="currencyFormat(activity.price)"></td>
                                    <td class="px-6 py-4" v-text="activity.date"></td>
                                    <td class="px-6 py-4 text-center">
                                        <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                           :href="'{{ route('activity.index') }}/' + activity.id + '/edit'"
                                           v-if="activity.from === 'admin' && !activity.invoiceID">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-if="!pageActivities.length">
                                    <td class="px-6 py-4 italic" colspan="5">
                                        No activities found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <nav class="flex items-center justify-between text-sm p-4"
                             v-if="filteredActivities.length">
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
            const { createApp, ref, computed, watch } = Vue

            createApp({
                setup() {
                    const activities = ref({!! $activities !!});
                    const keyword = ref('');
                    const filteredActivities = computed(() => {
                        return activities.value.filter(activity => {
                            const q = keyword.value.toLowerCase();
                            return activity.member.name.toLowerCase().includes(q)
                                || activity.member.memberID.toLowerCase().includes(q)
                                || activity.category.toLowerCase().includes(q)
                                || activity.detail.toLowerCase().includes(q)
                                || ('$' + activity.price).toLowerCase().includes(q)
                                || activity.date.toLowerCase().includes(q);
                        });
                    });
                    const per_page = 50;
                    const page = ref(1);
                    watch(keyword, () => page.value = 1);
                    const pageActivities = computed(() => {
                        return filteredActivities.value.filter((activity, index) => {
                            return (page.value - 1) * per_page <= index
                                && index < Math.min(page.value * per_page, filteredActivities.value.length);
                        });
                    });
                    const paginationInfo = computed(() => {
                        const total = filteredActivities.value.length;
                        const from = (page.value - 1) * per_page + 1;
                        const to = Math.min(page.value * per_page, total);
                        return `From ${from} to ${to} of ${total} activities`;
                    });
                    const isFirstPage = computed(() => {
                        return page.value === 1;
                    });
                    const prevPage = () => {
                        if (!isFirstPage.value) page.value--;
                    }
                    const isLastPage = computed(() => {
                        return page.value * per_page >= filteredActivities.value.length;
                    });
                    const nextPage = () => {
                        if (!isLastPage.value) page.value++;
                    }
                    const currencyFormat = window.currencyFormat;

                    return {
                        keyword, filteredActivities, pageActivities,
                        paginationInfo, isFirstPage, prevPage, isLastPage, nextPage,
                        currencyFormat,
                    }
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
