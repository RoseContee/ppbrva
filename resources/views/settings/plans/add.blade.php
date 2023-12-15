@php
$add = empty($plan);
$route = $add ? route('settings.plans.store') : route('settings.plans.update', $plan['id']);
@endphp

<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ $add ? 'Add' : 'Edit' }} Plan
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
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2"
                                               for="name">
                                            Plan Name
                                        </label>
                                        <input @class([
                                                    "appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-2 leading-tight focus:outline-none focus:bg-white",
                                                    "border-slate-300" => !$errors->first('name'),
                                                    "border-red-500" => $errors->first('name'),
                                                ])
                                               type="text" id="name" name="name" required
                                               value="{{ old('name', $plan['name'] ?? '') }}"
                                               placeholder="Name...">
                                        @error('name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                               for="price">
                                            Price
                                        </label>
                                        <input @class([
                                                "appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-2 leading-tight focus:outline-none focus:bg-white",
                                                "border-slate-300" => !$errors->first('name'),
                                                "border-red-500" => $errors->first('name'),
                                            ])
                                           type="number" id="price" name="price" required
                                               value="{{ old('price', $plan['price'] ?? '') }}"
                                               placeholder="Price">
                                        @error('price')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                               for="frequency">
                                            Frequency
                                        </label>
                                        @php $old = old('frequency', $plan['period'] ?? 'monthly'); @endphp
                                        <select class="appearance-none block w-full bg-gray-200 text-gray-700 border border-slate-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                id="frequency" name="frequency" required>
                                            <option value="monthly" @selected($old === 'monthly')>Monthly</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                               for="status">
                                            Status
                                        </label>
                                        @php $old = old('status', $plan['status'] ?? 'public'); @endphp
                                        <select class="appearance-none block w-full bg-gray-200 text-gray-700 border border-slate-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                id="status" name="status" required>
                                            <option value="public" @selected($old === 'public')>Public</option>
                                            <option value="private" @selected($old !== 'public')>Private</option>
                                        </select>
                                    </div>
                                </div>

                                <button class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        type="submit">
                                    {{ $add ? '+ Add' : 'Update' }} Plan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
