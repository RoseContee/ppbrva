<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Roles') }}
                    </h2>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-4">
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900">
                            <div>
                                <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center text-gray-500 bg-white border border-slate-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                    <span class="sr-only">Action button</span>
                                    Action
                                    <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                                        <li>
                                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
                                        </li>
                                        <li>
                                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
                                        </li>
                                        <li>
                                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate account</a>
                                        </li>
                                    </ul>
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete User</a>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ url('/settings/roles/add') }}" class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">+ Add Role</a>


                        </div>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-zinc-100 text-navy">
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Permissions
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Users
                                    </th>                
                                    <th scope="col" class="px-6 py-3 items-center">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div>
                                            <div class="text-base font-semibold"><a href="#" class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray">Admin</a></div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        Access to all views
                                    </td>                
                                    <td class="px-6 py-4">
                                        1
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray">Edit</a>
                                    </td>
                                </tr>

                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div>
                                            <div class="text-base font-semibold"><a href="#" class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray">Manager</a></div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        Members, Activity, Invoices
                                    </td>                
                                    <td class="px-6 py-4">
                                        3
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray">Edit</a>
                                    </td>
                                </tr>

                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div>
                                            <div class="text-base font-semibold"><a href="#" class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray">Staff</a></div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        Members
                                    </td>                
                                    <td class="px-6 py-4">
                                        12
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray">Edit</a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
