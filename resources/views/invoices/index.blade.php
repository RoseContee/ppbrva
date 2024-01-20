<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Invoices
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-4">
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900">
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

                            <div class="relative">
                                <button class="inline-flex items-center text-gray-500 bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        v-on:click="toggleMenu">
                                    <span v-text="'Filter: ' + filterText"></span>
                                    <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <div class="absolute right-0 hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                                     :style="{display: showMenu ? 'block' : 'none'}">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                               href="javascript:void(0);"
                                               :class="{'bg-zinc-100': filter === 'all'}"
                                               v-on:click="filter = 'all'; showMenu = false;">
                                                All
                                            </a>
                                        </li>
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                               href="javascript:void(0);"
                                               :class="{'bg-zinc-100': filter === 'paid'}"
                                               v-on:click="filter = 'paid'; showMenu = false;">
                                                Only Paid
                                            </a>
                                        </li>
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                               href="javascript:void(0);"
                                               :class="{'bg-zinc-100': filter === 'unpaid'}"
                                               v-on:click="filter = 'unpaid'; showMenu = false;">
                                                Only Unpaid
                                            </a>
                                        </li>
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                               href="javascript:void(0);"
                                               :class="{'bg-zinc-100': filter === 'unpaid-non0'}"
                                               v-on:click="filter = 'unpaid-non0'; showMenu = false;">
                                                Unpaid, No $0s
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-zinc-100 text-navy">
                                    <th scope="col" class="px-6 py-3">Member</th>
                                    <th scope="col" class="px-6 py-3">Invoice</th>
                                    <th scope="col" class="px-6 py-3">Period</th>
                                    <th scope="col" class="px-6 py-3">Amount</th>
                                    <th scope="col" class="px-6 py-3">Paid</th>
                                    <th scope="col" class="px-6 py-3 items-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="(invoice, index) in pageInvoices" key="index">
                                    <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <img class="w-10 h-10 rounded-full" v-if="invoice.member.avatar"
                                             :src="invoice.member.avatar"
                                             :alt="invoice.member.name">
                                        <div class="pl-3" v-if="invoice.member.name">
                                            <div class="text-base font-semibold">
                                                <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                                   :href="'{{ route('members.index') }}/' + invoice.member.id + '/edit'"
                                                   v-text="invoice.member.name"></a>
                                            </div>
                                            <div class="font-normal text-gray-500"
                                                 v-text="'#' + invoice.member.memberID"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" v-text="'#' + invoice.invoiceID"></td>
                                    <td class="px-6 py-4" v-text="invoice.period"></td>
                                    <td class="px-6 py-4" v-text="currencyFormat(invoice.amount)"></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full mr-2"
                                                 :class="{'bg-green-500': invoice.paid, 'bg-red-500': !invoice.paid}"></div>
                                            <span v-text="invoice.paid ? 'Yes' : 'No'"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                           :href="'{{ route('invoices.index') }}/' + invoice.id">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-if="!pageInvoices.length">
                                    <td class="px-6 py-4 italic" colspan="6">
                                        No invoices found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <nav class="flex items-center justify-between text-sm p-4"
                             v-if="filteredInvoices.length">
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
                    const invoices = ref({!! $invoices !!});
                    const keyword = ref('');
                    const filter = ref('all');
                    const filteredInvoices = computed(() => {
                        return invoices.value.filter(invoice => {
                            const q = keyword.value.toLowerCase();
                            return (invoice.member.name.toLowerCase().includes(q)
                                || invoice.member.memberID.toLowerCase().includes(q)
                                || invoice.invoiceID.toLowerCase().includes(q)
                                || invoice.period.toLowerCase().includes(q)
                                || ('$' + invoice.amount).toLowerCase().includes(q)
                            ) && (filter.value === 'all'
                                || (filter.value === 'paid' && !!invoice.paid)
                                || (filter.value === 'unpaid' && !invoice.paid)
                                || (filter.value === 'unpaid-non0' && !invoice.paid && invoice.amount > 0)
                            );
                        });
                    });
                    const per_page = 50;
                    const page = ref(1);
                    watch(keyword, () => page.value = 1);
                    watch(filter, () => page.value = 1);
                    const pageInvoices = computed(() => {
                        return filteredInvoices.value.filter((invoice, index) => {
                            return (page.value - 1) * per_page <= index
                                && index < Math.min(page.value * per_page, filteredInvoices.value.length);
                        });
                    });
                    const showMenu = ref(false);
                    const toggleMenu = () => {
                        showMenu.value = !showMenu.value;
                    }
                    const filterText = computed(() => {
                        if (filter.value === 'paid') return 'Only Paid';
                        if (filter.value === 'unpaid') return 'Only Unpaid';
                        if (filter.value === 'unpaid-non0') return 'Unpaid, No $0s';
                        return 'All';
                    });
                    const paginationInfo = computed(() => {
                        const total = filteredInvoices.value.length;
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
                        return page.value * per_page >= filteredInvoices.value.length;
                    });
                    const nextPage = () => {
                        if (!isLastPage.value) page.value++;
                    }
                    const currencyFormat = window.currencyFormat;

                    return {
                        keyword, filter, filteredInvoices, pageInvoices,
                        showMenu, toggleMenu, filterText,
                        paginationInfo, isFirstPage, prevPage, isLastPage, nextPage,
                        currencyFormat,
                    }
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
