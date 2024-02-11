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

                            <div class="flex items-center">
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
                                                   :class="{'bg-zinc-100': filter === 'plan'}"
                                                   v-on:click="filter = 'plan'; showFilter = false;">
                                                    By Plan
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': filter === 'status'}"
                                                   v-on:click="filter = 'status'; showFilter = false;">
                                                    By Status
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': filter === 'lastAsc'}"
                                                   v-on:click="filter = 'lastAsc'; showFilter = false;">
                                                    Last Name A-Z
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': filter === 'lastDesc'}"
                                                   v-on:click="filter = 'lastDesc'; showFilter = false;">
                                                    Last Name Z-A
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': filter === 'firstAsc'}"
                                                   v-on:click="filter = 'firstAsc'; showFilter = false;">
                                                    First Name A-Z
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': filter === 'firstDesc'}"
                                                   v-on:click="filter = 'firstDesc'; showFilter = false;">
                                                    First Name Z-A
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': filter === 'highest'}"
                                                   v-on:click="filter = 'highest'; showFilter = false;">
                                                    Highest Membership ID#
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': filter === 'lowest'}"
                                                   v-on:click="filter = 'lowest'; showFilter = false;">
                                                    Lowest Membership ID#
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="relative hidden mr-2"
                                     :style="{display: filter === 'plan' ? 'block' : 'none'}">
                                    <button class="inline-flex items-center text-gray-500 bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                            v-on:click="togglePlanFilter">
                                        <span v-text="'Plan: ' + planFilterText"></span>
                                        <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <div class="absolute hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                                         :style="{display: showPlanFilter ? 'block' : 'none'}">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                            @foreach ($plans as $plan)
                                                <li>
                                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                       href="javascript:void(0);"
                                                       :class="{'bg-zinc-100': planFilter === '{{ $plan['id'] }}'}"
                                                       v-on:click="planFilter = '{{ $plan['id'] }}'; showPlanFilter = false;">
                                                        {{ $plan['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="relative mr-2"
                                     :style="{display: filter === 'status' ? 'block' : 'none'}">
                                    <button class="inline-flex items-center text-gray-500 bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                            v-on:click="toggleStatusFilter">
                                        <span v-text="'Status: ' + statusFilterText"></span>
                                        <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <div class="absolute hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                                         :style="{display: showStatusFilter ? 'block' : 'none'}">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': statusFilter === 'active'}"
                                                   v-on:click="statusFilter = 'active'; showStatusFilter = false;">
                                                    Active
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': statusFilter === 'inactive'}"
                                                   v-on:click="statusFilter = 'inactive'; showStatusFilter = false;">
                                                    Inactive
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': statusFilter === 'paused'}"
                                                   v-on:click="statusFilter = 'paused'; showStatusFilter = false;">
                                                    Paused
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': statusFilter === 'suspended'}"
                                                   v-on:click="statusFilter = 'suspended'; showStatusFilter = false;">
                                                    Suspended
                                                </a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                   href="javascript:void(0);"
                                                   :class="{'bg-zinc-100': statusFilter === 'pending'}"
                                                   v-on:click="statusFilter = 'pending'; showStatusFilter = false;">
                                                    Pending
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

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
                                    <th scope="col" class="px-6 py-3">CC</th>
                                    <th scope="col" class="px-6 py-3 items-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="(member, index) in pageMembers" key="index">
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
                                    <td class="px-6 py-4" v-text="member.plan.name"></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full mr-2"
                                                 :class="{'bg-green-500': member.status === 'active', 'bg-red-500': member.status !== 'active'}"></div>
                                            <span class="capitalize" v-text="member.status"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <svg class="w-6 h-6" v-if="member.card_last4"
                                             fill="#22c55e" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 117.72 117.72">
                                            <g><path class="st0" d="M58.86,0c9.13,0,17.77,2.08,25.49,5.79c-3.16,2.5-6.09,4.9-8.82,7.21c-5.2-1.89-10.81-2.92-16.66-2.92 c-13.47,0-25.67,5.46-34.49,14.29c-8.83,8.83-14.29,21.02-14.29,34.49c0,13.47,5.46,25.66,14.29,34.49 c8.83,8.83,21.02,14.29,34.49,14.29s25.67-5.46,34.49-14.29c8.83-8.83,14.29-21.02,14.29-34.49c0-3.2-0.31-6.34-0.9-9.37 c2.53-3.3,5.12-6.59,7.77-9.85c2.08,6.02,3.21,12.49,3.21,19.22c0,16.25-6.59,30.97-17.24,41.62 c-10.65,10.65-25.37,17.24-41.62,17.24c-16.25,0-30.97-6.59-41.62-17.24C6.59,89.83,0,75.11,0,58.86 c0-16.25,6.59-30.97,17.24-41.62S42.61,0,58.86,0L58.86,0z M31.44,49.19L45.8,49l1.07,0.28c2.9,1.67,5.63,3.58,8.18,5.74 c1.84,1.56,3.6,3.26,5.27,5.1c5.15-8.29,10.64-15.9,16.44-22.9c6.35-7.67,13.09-14.63,20.17-20.98l1.4-0.54H114l-3.16,3.51 C101.13,30,92.32,41.15,84.36,52.65C76.4,64.16,69.28,76.04,62.95,88.27l-1.97,3.8l-1.81-3.87c-3.34-7.17-7.34-13.75-12.11-19.63 c-4.77-5.88-10.32-11.1-16.79-15.54L31.44,49.19L31.44,49.19z"/></g>
                                        </svg>
                                        <svg class="w-5 h-5" v-else
                                             fill="#ef4444" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.878 122.88">
                                            <g><path d="M1.426,8.313c-1.901-1.901-1.901-4.984,0-6.886c1.901-1.902,4.984-1.902,6.886,0l53.127,53.127l53.127-53.127 c1.901-1.902,4.984-1.902,6.887,0c1.901,1.901,1.901,4.985,0,6.886L68.324,61.439l53.128,53.128c1.901,1.901,1.901,4.984,0,6.886 c-1.902,1.902-4.985,1.902-6.887,0L61.438,68.326L8.312,121.453c-1.901,1.902-4.984,1.902-6.886,0 c-1.901-1.901-1.901-4.984,0-6.886l53.127-53.128L1.426,8.313L1.426,8.313z"/></g>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div v-if="member.status !== 'pending'">
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
                                        </div>
                                        <div v-else>
                                            <p class="text-center">
                                                <button class="px-2 py-1 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                        v-on:click="approveMember(member.id)">
                                                    Approve
                                                </button>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-if="!pageMembers.length">
                                    <td class="px-6 py-4 italic" colspan="8">
                                        No members found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <nav class="flex items-center justify-between text-sm p-4"
                             v-if="filteredMembers.length">
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
    <form name="inviteForm" action="{{ route('members.send-invite') }}" method="POST">
        @csrf
        <input type="hidden" id="inviteMemberId" name="member">
    </form>
    <form name="approvalForm" action="{{ route('members.approve') }}" method="POST">
        @csrf
        <input type="hidden" id="approvalMemberId" name="member">
    </form>
    <form name="deleteForm" action="{{ route('members.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="members" v-model="selectedItems">
    </form>

    @push('scripts')
        <script type="module">
            const { createApp, ref, computed, watch } = Vue;

            createApp({
                setup() {
                    const members = ref({!! $members !!});
                    const keyword = ref('');
                    const filter = ref('all');
                    const planFilter = ref('{{ $plans[0]['id'] ?? '' }}');
                    const statusFilter = ref('active');
                    const filteredMembers = computed(() => {
                        return members.value.filter(member => {
                            const q = keyword.value.toLowerCase();
                            return (member.name.toLowerCase().includes(q)
                                || member.memberID.toLowerCase().includes(q)
                            ) && ((filter.value === 'plan' && member.plan_id == planFilter.value)
                                || (filter.value === 'status' && member.status === statusFilter.value)
                                || [
                                    'all',
                                    'lastAsc', 'lastDesc',
                                    'firstAsc', 'firstDesc',
                                    'highest', 'lowest'
                                ].includes(filter.value)
                            )
                        }).sort((a, b) => {
                            if (filter.value === 'lastAsc') {
                                return a.lastname.toLowerCase().localeCompare(b.lastname.toLowerCase());
                            }
                            if (filter.value === 'lastDesc') {
                                return b.lastname.toLowerCase().localeCompare(a.lastname.toLowerCase());
                            }
                            if (filter.value === 'firstAsc') {
                                return a.firstname.toLowerCase().localeCompare(b.firstname.toLowerCase());
                            }
                            if (filter.value === 'firstDesc') {
                                return b.firstname.toLowerCase().localeCompare(a.firstname.toLowerCase());
                            }
                            if (filter.value === 'highest') {
                                return b.id - a.id;
                            }
                            return a.id - b.id;
                        });
                    });
                    const per_page = 50;
                    const page = ref(1);
                    watch(keyword, () => page.value = 1);
                    watch(filter, () => {
                        if (['plan', 'status'].includes(filter.value)) page.value = 1;
                    });
                    watch(planFilter, () => page.value = 1);
                    watch(statusFilter, () => page.value = 1);
                    const pageMembers = computed(() => {
                        return filteredMembers.value.filter((member, index) => {
                            return (page.value - 1) * per_page <= index
                                && index < Math.min(page.value * per_page, filteredMembers.value.length)
                        });
                    });
                    const showFilter = ref(false);
                    const toggleFilter = () => {
                        showFilter.value = !showFilter.value;
                    }
                    const filterText = computed(() => {
                        if (filter.value === 'plan') return 'By Plan';
                        if (filter.value === 'status') return 'By Status';
                        if (filter.value === 'lastAsc') return 'Last Name A-Z';
                        if (filter.value === 'lastDesc') return 'Last Name Z-A';
                        if (filter.value === 'firstAsc') return 'First Name A-Z';
                        if (filter.value === 'firstDesc') return 'First Name Z-A';
                        if (filter.value === 'highest') return 'Highest Membership ID#';
                        if (filter.value === 'lowest') return 'Lowest Membership ID#';
                        return 'All';
                    });
                    const showPlanFilter = ref(false);
                    const togglePlanFilter = () => {
                        showPlanFilter.value = !showPlanFilter.value;
                    }
                    const planFilterText = computed(() => {
                        const plans = {{ Js::from($plans) }};
                        return plans.find(plan => plan.id == planFilter.value)?.name;
                    });
                    const showStatusFilter = ref(false);
                    const toggleStatusFilter = () => {
                        showStatusFilter.value = !showStatusFilter.value;
                    }
                    const statusFilterText = computed(() => {
                        return [...statusFilter.value].map((char, index) => index ? char : char.toUpperCase()).join('');
                    });
                    const paginationInfo = computed(() => {
                        const total = filteredMembers.value.length;
                        const from = (page.value - 1) * per_page + 1;
                        const to = Math.min(page.value * per_page, total);
                        return `From ${from} to ${to} of ${total} members`;
                    });
                    const isFirstPage = computed(() => {
                        return page.value === 1;
                    });
                    const prevPage = () => {
                        if (!isFirstPage.value) page.value--;
                    }
                    const isLastPage = computed(() => {
                        return page.value * per_page >= filteredMembers.value.length
                    });
                    const nextPage = () => {
                        if (!isLastPage.value) page.value++;
                    }
                    const selectedAll = ref(false);
                    const selectedItems = ref([]);
                    const selectAll = (checked) => {
                        if (checked) {
                            selectedItems.value = filteredMembers.value.map(member => member.id);
                        } else {
                            selectedItems.value = [];
                        }
                    }
                    const selectItem = (item, checked) => {
                        if (checked) {
                            selectedItems.value = [
                                ...selectedItems.value.filter(el => el <= item.id),
                                item.id,
                                ...selectedItems.value.filter(el => el > item.id),
                            ];
                        } else {
                            selectedItems.value = selectedItems.value.filter(el => el !== item.id);
                        }
                        selectedAll.value = selectedItems.value.length === filteredMembers.value.length;
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
                    const approveMember = (memberId) => {
                        if (confirm('This will send an email invite to member. Are you sure?')) {
                            document.getElementById('approvalMemberId').value = memberId;
                            document.approvalForm.submit();
                        }
                    }

                    return {
                        keyword, filter, planFilter, statusFilter, filteredMembers, pageMembers,
                        showFilter, toggleFilter, filterText,
                        showPlanFilter, togglePlanFilter, planFilterText,
                        showStatusFilter, toggleStatusFilter, statusFilterText,
                        paginationInfo, isFirstPage, prevPage, isLastPage, nextPage,
                        selectedAll, selectAll, selectedItems, selectItem,
                        showMenu, toggleMenu, deleteItems,
                        sendInvite, approveMember,
                    }
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
