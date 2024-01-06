<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        General Settings
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <form class="flex items-center justify-between p-4 bg-white dark:bg-gray-900"
                              action="{{ route('settings.general.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="w-full max-w-lg">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2"
                                               for="contact_email">
                                            Contact Email
                                        </label>
                                        <input @class([
                                                    "appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-2 leading-tight focus:outline-none focus:bg-white",
                                                    "border-slate-300" => !$errors->first('contact_email'),
                                                    "border-red-500" => $errors->first('contact_email'),
                                                ])
                                               type="email" id="contact_email" name="contact_email" required
                                               value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                               placeholder="Contact Email...">
                                        @error('contact_email')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2"
                                               for="dupr_link">
                                            DUPR Link
                                        </label>
                                        <input @class([
                                                    "appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-2 leading-tight focus:outline-none focus:bg-white",
                                                    "border-slate-300" => !$errors->first('dupr_link'),
                                                    "border-red-500" => $errors->first('dupr_link'),
                                                ])
                                               type="url" id="dupr_link" name="dupr_link" required
                                               value="{{ old('dupr_link', $settings['dupr_link'] ?? '') }}"
                                               placeholder="DUPR Link...">
                                        @error('dupr_link')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2"
                                               for="secondary_limit">
                                            Secondary account limit (Family Plan)
                                        </label>
                                        <input @class([
                                                    "appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-2 leading-tight focus:outline-none focus:bg-white",
                                                    "border-slate-300" => !$errors->first('secondary_limit'),
                                                    "border-red-500" => $errors->first('secondary_limit'),
                                                ])
                                               type="number" id="secondary_limit" name="secondary_limit" required
                                               value="{{ old('secondary_limit', $settings['secondary_limit'] ?? '') }}"
                                               placeholder="Secondary account limit...">
                                        @error('secondary_limit')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
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
