<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Locations') }}
                    </h2>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900">


                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-slate-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search by name...">
                            </div>

                            <a href="{{ url('/locations/add') }}" class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">+ Add Location</a>
                        </div>

                </div>


                <div class="flex">
                        <div class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700 m-6">
                            <a href="#!">
                                <img
                                class="rounded-t-lg"
                                src="{{ url('/img/ppb-roanoke.jpg') }}" 
                                alt="" />
                            </a>
                            <div class="p-6">
                                <h5
                                class="mb-2 text-xl font-medium leading-tight text-neutral-800 dark:text-neutral-50">
                                <a href="#" class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray">Roanoke</a>
                                </h5>
                                <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200">
                                123 Any Street
                                Roanoke, VA 21938
                                </p>
                                <button
                                type="button"
                                class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                data-te-ripple-init
                                data-te-ripple-color="light">
                                Manage
                                </button>
                            </div>
                            </div>

                            <div class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700 m-6">
                            <a href="#!">
                                <img
                                class="rounded-t-lg"
                                src="{{ url('/img/ppb-richmond.jpg') }}" 
                                alt="" />
                            </a>
                            <div class="p-6">
                                <h5
                                class="mb-2 text-xl font-medium leading-tight text-neutral-800 dark:text-neutral-50">
                                <a href="#" class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray">Richmond</a>
                                </h5>
                                <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200">
                                8641 Quioccasin Rd Henrico, VA 23229
                                </p>
                                <button
                                type="button"
                                class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                data-te-ripple-init
                                data-te-ripple-color="light">
                                Manage
                                </button>
                            </div>
                            </div>
                            </div>

                    </div>


            </div>
        </div>
    </div>
</x-app-layout>
