<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Members
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-4">
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900">
                            <div>
                                <button class="inline-flex items-center text-gray-500 bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        v-on:click="toggleMenu">
                                    <span class="sr-only">Action button</span>
                                    Action
                                    <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <div class="absolute hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                                     :style="{display: showMenu ? 'block' : 'none'}">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                               href="javascript:void(0);"
                                               v-on:click="deleteItems">
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input class="block p-2 pl-10 text-sm text-gray-900 border border-slate-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       type="text"
                                       placeholder="Search name or member ID..."
                                       v-model="keyword">
                            </div>

                            <a class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                               href="{{ route('members.create') }}">
                                + Add Member
                            </a>
                        </div>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-zinc-100 text-navy">
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                   type="checkbox"
                                                   id="select-all"
                                                   v-model="selectedAll"
                                                   v-on:change="e => selectAll(e.target.checked)">
                                            <label for="select-all" class="sr-only">Select All</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">Member</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Phone</th>
                                    <th scope="col" class="px-6 py-3">Plan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 items-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="(member, index) in filteredMembers" key="index">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                   type="checkbox"
                                                   :id="'member-' + member.id"
                                                   :checked="selectedItems.includes(member.id)"
                                                   v-on:change="e => selectItem(member, e.target.checked)">
                                            <label :for="'member-' + member.id" class="sr-only">Select</label>
                                        </div>
                                    </td>
                                    <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <img class="w-10 h-10 rounded-full"
                                             :src="member.avatar"
                                             :alt="member.name">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">
                                                <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                                   :href="'{{ route('members.index') }}/' + member.id + '/edit'"
                                                   v-text="member.name"></a>
                                            </div>
                                            <div class="font-normal text-gray-500"
                                                 v-text="'#' + member.memberID"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" v-text="member.email"></td>
                                    <td class="px-6 py-4" v-text="member.phone"></td>
                                    <td class="px-6 py-4" v-text="member.plan_name"></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"
                                                 :class="{'bg-green-500': member.active, 'bg-red-500': !member.active}"></div>
                                            <span v-text="member.active ? 'Active' : 'Inactive'"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-center">
                                            <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                               :href="'{{ route('members.index') }}/' + member.id + '/edit'">
                                                Edit
                                            </a>
                                        </p>
                                        <p class="text-center mt-1"
                                           v-if="member.original_pass">
                                            <a class="font-medium text-red-500 underline dark:text-red-500 hover:no-underline hover:text-gray"
                                               href="javascript:void(0);"
                                               v-on:click="sendInvite(member.id)">
                                                Send Invite
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-if="!filteredMembers.length">
                                    <td class="px-6 py-4 italic" colspan="7">
                                        No members found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <nav class="flex items-center justify-between text-sm p-4"
                             v-if="members.length">
                            <span v-text="pagination_info"></span>
                            <ul class="flex -space-x-px h-8">
                                <li>
                                    <a class="flex items-center justify-center bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-gray-200 font-medium rounded-l-lg text-sm px-3 h-8 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 text-gray-500"
                                       :class="{'cursor-not-allowed': firstPage}"
                                       v-on:click="prevPage">
                                        <span class="sr-only">Previous</span>
                                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center justify-center bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-gray-200 font-medium rounded-r-lg text-sm px-3 h-8 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 text-gray-500"
                                       :class="{'cursor-not-allowed': lastPage}"
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
    <form name="inviteForm" action="{{ route('members.send-invite') }}" method="POST">
        @csrf
        <input type="hidden" id="inviteMemberId" name="member">
    </form>
    <form name="deleteForm" action="{{ route('members.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="members" v-model="selectedItems">
    </form>

    @push('scripts')
        <script type="module">
            const { createApp, ref, computed } = Vue

            createApp({
                setup() {
                    const per_page = 50;
                    const members = ref({!! $members !!});
                    const keyword = ref('');
                    const page = ref(1);
                    const pagination_info = computed(() => {
                        const total = members.value.length;
                        const from = (page.value - 1) * per_page + 1;
                        const to = Math.min(page.value * per_page, total);
                        return `From ${from} to ${to} of ${total} members`;
                    });
                    const firstPage = computed(() => page.value === 1);
                    const prevPage = () => {
                        if (!firstPage.value) page.value--;
                    }
                    const lastPage = computed(() => page.value * per_page >= members.value.length);
                    const nextPage = () => {
                        if (!lastPage.value) page.value++;
                    }
                    const filteredMembers = computed(() => {
                        return members.value.filter((member, index) => {
                            return (member.name.toLowerCase().indexOf(keyword.value.toLowerCase()) !== -1
                                    || member.memberID.toLowerCase().indexOf(keyword.value.toLowerCase()) !== -1
                                ) && (page.value - 1) * per_page <= index
                                && index < Math.min(page.value * per_page, members.value.length);
                        });
                    });
                    const selectedAll = ref(false);
                    const selectedItems = ref([]);
                    const selectAll = (checked) => {
                        if (checked) selectedItems.value = members.value.map(item => item.id);
                        else selectedItems.value = [];
                    }
                    const selectItem = (item, checked) => {
                        if (checked) selectedItems.value.push(item.id);
                        else selectedItems.value = selectedItems.value.filter(el => el !== item.id);
                        let all = true;
                        members.value.forEach(item => {
                            if (!selectedItems.value.includes(item.id)) all = false;
                        });
                        selectedAll.value = all;
                    };
                    const showMenu = ref(false);
                    const toggleMenu = () => {
                        showMenu.value = !showMenu.value;
                    }
                    const deleteItems = () => {
                        toggleMenu();
                        if (selectedItems.value.length && confirm('Are you sure to delete?')) {
                            document.deleteForm.submit();
                        }
                    }
                    const sendInvite = (memberId) => {
                        if (confirm('Are you sure to send invitation to this member again?')) {
                            document.getElementById('inviteMemberId').value = memberId;
                            document.inviteForm.submit();
                        }
                    }

                    return {
                        members, keyword,
                        pagination_info, firstPage, prevPage, lastPage, nextPage, filteredMembers,
                        selectedAll, selectAll, selectedItems, selectItem,
                        showMenu, toggleMenu, deleteItems,
                        sendInvite,
                    }
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
