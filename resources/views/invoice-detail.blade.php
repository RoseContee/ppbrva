<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Invoice #1209329') }}
                    </h2>


                    <a href="#" class="inline-flex float-right mt-5 px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Download PDF</a>



                    <div class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <img class="w-10 h-10 rounded-full" src="{{ url('/img/profile-picture-1.jpg') }}" alt="Jese image">
                        <div class="pl-3">
                            <div class="text-base font-semibold"><a href="{{ url('/members/') }}" class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray">Neil Sims</a></div>
                            <div class="font-normal text-gray-500">December 2023</div>
                        </div>  
                    </div>



                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-4">


                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-zinc-100 text-navy">
                                    <th scope="col" class="px-6 py-3">
                                        Item
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Detail
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Amount
                                    </th>                

                                    <th scope="col" class="px-6 py-3 items-center">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">Food & Beverage</div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        2 Guinness, 1 Club Sandwich
                                    </td>                
                                    <td class="px-6 py-4">
                                        $32.00
                                    </td>
                                </tr>
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">Lessons</div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        2x 1-hour session
                                    </td>                
                                    <td class="px-6 py-4">
                                        $200.00
                                    </td>
                                </tr>               
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">Court Usage</div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        4x, 1-hour session
                                    </td>                
                                    <td class="px-6 py-4">
                                        $250.00
                                    </td>
                                </tr>       
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">Rentals</div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        N/A
                                    </td>                
                                    <td class="px-6 py-4">
                                        $0.00
                                    </td>
                                </tr>          
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">Merchandise</div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        N/A
                                    </td>                
                                    <td class="px-6 py-4">
                                        $0.00
                                    </td>
                                </tr>           
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">Membership Dues</div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        Elite Team Membership
                                    </td>                
                                    <td class="px-6 py-4">
                                        $119.00
                                    </td>
                                </tr>                              
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">TOTAL</div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4">
                                        
                                    </td>                
                                    <td class="px-6 py-4">
                                        $601.00
                                    </td>
                                </tr>                                                                                                                                       
                            </tbody>
                        </table>

                        <p class="m-6 text-center">Paid on 12/31/23 @ 11:02PM using VISA ending in ****1234
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
