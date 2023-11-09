@php
    $add = empty($activity);
    $route = $add ? route('activity.store') : route('activity.update', $activity['id']);
@endphp

<x-app-layout>
    @push('styles')
        <style>
            .select2-container .select2-selection--single {
                height: 46px;
                @if ($errors->first('member'))
                    border-color: rgb(239 68 68 / var(--tw-border-opacity));
                @else
                    border-color: rgb(203 213 225 / var(--tw-border-opacity));
                @endif
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                padding-left: 1rem;
                line-height: 46px;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 44px;
            }
        </style>
    @endpush
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ $add ? 'Add' : 'Edit' }} Activity
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
                                        <label for="member" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Member Name
                                        </label>
                                        <select @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('member'),
                                                   "border-red-500" => $errors->first('member'),
                                               ])
                                                id="member" name="member" required>
                                            @foreach ($members as $member)
                                                <option value="{{ $member['id'] }}"
                                                    @selected(old('member', $activity['member_id'] ?? '') == $member['id'])>
                                                    {{ $member['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('member')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="category" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Category
                                        </label>
                                        <select @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('category'),
                                                   "border-red-500" => $errors->first('category'),
                                               ])
                                                id="category" name="category" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category['name'] }}"
                                                    @selected(old('category', $activity['category'] ?? '') === $category['name'])>
                                                    {{ $category['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="detail" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Detail
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('detail'),
                                                   "border-red-500" => $errors->first('detail'),
                                               ])
                                               type="text" id="detail" name="detail" required
                                               value="{{ old('detail', $activity['detail'] ?? '') }}"
                                               placeholder="Detail...">
                                        @error('detail')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="amount" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Amount ($)
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('amount'),
                                                   "border-red-500" => $errors->first('amount'),
                                               ])
                                               type="number" id="amount" name="amount" required
                                               value="{{ old('amount', $activity['price'] ?? '') }}"
                                               placeholder="Amount...">
                                        @error('amount')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="date" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Date
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('date'),
                                                   "border-red-500" => $errors->first('date'),
                                               ])
                                               type="text" id="date" name="date" required
                                               value="{{ old('date', !empty($activity['date']) ? date('m/d/Y', strtotime($activity['date'])) : '') }}"
                                               placeholder="MM/DD/YYYY">
                                        @error('date')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ $add ? '+ Add' : 'Update' }} Activity
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(function() {
                $('#member').select2({
                    selectionCssClass: '{{ !$errors->first('member') ? 'border-red-500' : 'border-slate-300' }}'
                });

                new Datepicker(document.getElementById('date'), {
                    autohide: true,
                });
            });
        </script>
    @endpush
</x-app-layout>
