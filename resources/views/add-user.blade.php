<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Add User') }}
                    </h2>


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900">
                            <form class="w-full max-w-lg">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2" for="grid-first-name">
                                        User Name
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Harvey Potter">
                                    <p class="text-red-500 text-xs italic">Please fill out this field.</p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                        Phone
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-slate-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="password" placeholder="(804) 555-1234">
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                        Email
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-slate-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="password" placeholder="contact@email.com">
                                    </div>
                                </div>


                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                        Role
                                    </label>
                                    <select class="appearance-none block w-full bg-gray-200 text-gray-700 border border-slate-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option>Choose...</option>
                                    </select>
                                    </div>
                                </div>


                                <a href="{{ url('/users') }}" class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">+ Add User</a>

                            </form>

                            <div>
                                <img src="{{ url('/img/profile-picture-2.jpg') }}" class="w-96 mb-5" />

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                        Change Avatar
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-slate-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="password" placeholder="Choose file...">
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
