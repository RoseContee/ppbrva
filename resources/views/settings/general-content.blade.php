<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        General Content
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <form class="flex items-center justify-between p-4 bg-white dark:bg-gray-900"
                              action="{{ route('settings.general-content.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="w-full">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2"
                                               for="first_payment">
                                            First Payment
                                        </label>
                                        <textarea @class([
                                                    "appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-2 leading-tight focus:outline-none focus:bg-white",
                                                    "border-slate-300" => !$errors->first('first_payment'),
                                                    "border-red-500" => $errors->first('first_payment'),
                                                ])
                                               id="first_payment" name="first_payment" required rows="10"
                                               placeholder="">{{ old('first_payment', $settings['first_payment'] ?? '') }}</textarea>
                                        @error('first_payment')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                        <p class="text-xs pl-3">
                                            <span class="italic">$$YEAR</span> - A four digit representation of a year<br>
                                            <span class="italic">$$MONTH</span> - A full textual representation of a month<br>
                                            <span class="italic">$$PLAN</span> - Membership plan name<br>
                                            <span class="italic">$$RATE</span> - Daily rate for membership plan<br>
                                            <span class="italic">$$DAYS</span> - Number of days left<br>
                                            <span class="italic">$$TOTAL</span> - $$RATE * $$DAYS<br>
                                        </p>
                                    </div>
                                </div>

                                <button class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        type="submit">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
