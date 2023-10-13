<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Dashboard') }}
                    </h2>
                </div>                        


                        <div class="flex flex-row-reverse bg-white dark:bg-gray-900">

                        <button class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Apply</button>


                        <div class="relative mx-3">
                                <!-- <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div> -->
                                <input type="text" id="table-search-users" class="block p-2 text-sm text-gray-900 border border-slate-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="End Date...">
                            </div>                            



                            <div class="relative">
                                <!-- <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div> -->
                                <input type="text" id="table-search-users" class="block p-2 text-sm text-gray-900 border border-slate-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Start Date...">
                            </div>


                        </div>


                <div class="bg-gray-200 flex flex-wrap items-center justify-between px-5 py-5">
                    <div class="w-full">
                        <div class="-mx-2 md:flex">
                            <div class="w-full md:w-1/3 px-2">
                                <div class="rounded-lg shadow-sm mb-4">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                        <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                            <h4 class="text-sm uppercase text-gray-500 leading-tight">Members</h4>
                                            <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">982</h3>
                                            <p class="text-xs text-green-500 leading-tight">▲ 57.1%</p>
                                        </div>
                                        <div class="absolute bottom-0 inset-x-0">
                                            <canvas id="chart1" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-2">
                                <div class="rounded-lg shadow-sm mb-4">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                        <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                            <h4 class="text-sm uppercase text-gray-500 leading-tight">Payments</h4>
                                            <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">$187,427</h3>
                                            <p class="text-xs text-green-500 leading-tight">▲ 42.8%</p>
                                        </div>
                                        <div class="absolute bottom-0 inset-x-0">
                                            <canvas id="chart2" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-2">
                                <div class="rounded-lg shadow-sm mb-4">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                        <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                            <h4 class="text-sm uppercase text-gray-500 leading-tight">Dues</h4>
                                            <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">$102,512</h3>
                                            <p class="text-xs text-green-500 leading-tight">▲ 9.1%</p>
                                        </div>
                                        <div class="absolute bottom-0 inset-x-0">
                                            <canvas id="chart3" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-2">
                                <div class="rounded-lg shadow-sm mb-4">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                        <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                            <h4 class="text-sm uppercase text-gray-500 leading-tight">Lessons</h4>
                                            <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">$17,123</h3>
                                            <p class="text-xs text-green-500 leading-tight">▲ 4.1%</p>
                                        </div>
                                        <div class="absolute bottom-0 inset-x-0">
                                            <canvas id="chart3" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="w-full md:w-1/3 px-2">
                                <div class="rounded-lg shadow-sm mb-4">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                        <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                            <h4 class="text-sm uppercase text-gray-500 leading-tight">Kitchen/Bar</h4>
                                            <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">$52,427</h3>
                                            <p class="text-xs text-red-500 leading-tight">▼ 18.5%</p>
                                        </div>
                                        <div class="absolute bottom-0 inset-x-0">
                                            <canvas id="chart2" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-2">
                                <div class="rounded-lg shadow-sm mb-4">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                        <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                            <h4 class="text-sm uppercase text-gray-500 leading-tight">Merchandise</h4>
                                            <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">$14,238</h3>
                                            <p class="text-xs text-green-500 leading-tight">▲ 18.5%</p>
                                        </div>
                                        <div class="absolute bottom-0 inset-x-0">
                                            <canvas id="chart2" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>                            

                        </div>
                    </div>
</div>


            </div>      
        </div>
    </div>
</x-app-layout>