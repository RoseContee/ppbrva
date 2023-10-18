@php
$add = empty($location);
$route = $add ? route('locations.store') : route('locations.update', $location['id']);
@endphp

<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ $add ? 'Add' : 'Edit' }} Location
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <form class="flex items-center justify-between p-4 bg-white dark:bg-gray-900"
                              action="{{ $route }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (!$add)
                                @method('PUT')
                            @endif
                            <div class="w-full max-w-lg">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3 mb-6 md:mb-0">
                                        <label for="name" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Location Name
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('name'),
                                                   "border-red-500" => $errors->first('name'),
                                               ])
                                               type="text" id="name" name="name" required
                                               value="{{ old('name', $location['name'] ?? '') }}"
                                               placeholder="Location Name...">
                                        @error('name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="address" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Address
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('address'),
                                                   "border-red-500" => $errors->first('address'),
                                               ])
                                               type="text" id="address" name="address" required
                                               value="{{ old('address', $location['address'] ?? '') }}"
                                               placeholder="Address...">
                                        @error('address')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                        <p class="text-gray-600 text-xs italic">Enter address and choose the correct result</p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="phone" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Phone
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('phone'),
                                                   "border-red-500" => $errors->first('phone'),
                                               ])
                                               type="text" id="phone" name="phone" required
                                               value="{{ old('phone', $location['phone'] ?? '') }}"
                                               placeholder="Phone...">
                                        @error('phone')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="email" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Email
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('email'),
                                                   "border-red-500" => $errors->first('email'),
                                               ])
                                               type="email" id="email" name="email" required
                                               value="{{ old('email', $location['email'] ?? '') }}"
                                               placeholder="Email...">
                                        @error('email')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="website" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Website
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('website'),
                                                   "border-red-500" => $errors->first('website'),
                                               ])
                                               type="url" id="website" name="website" required
                                               value="{{ old('website', $location['website'] ?? '') }}"
                                               placeholder="Website...">
                                        @error('website')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ $add ? '+ Add' : 'Update' }} Location
                                </button>
                            </div>

                            <div class="w-full max-w-lg">
                                @if (!$add)
                                    <img src="{{ asset($location['image']) }}" alt="Image"
                                         class="w-96 mb-5" />
                                @endif
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="image" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Upload Image
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('image'),
                                                   "border-red-500" => $errors->first('image'),
                                               ])
                                               type="file" id="image" name="image" @required($add)
                                               accept="image/*"
                                               placeholder="Choose Image...">
                                        @error('image')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
