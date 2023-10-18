@php
$add = empty($user);
$route = $add ? route('users.store') : route('users.update', $user['id']);
$user_id = $user['id'] ?? '';
@endphp

<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ $add ? 'Add' : 'Edit' }} User
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
                                            User Name
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('name'),
                                                   "border-red-500" => $errors->first('name'),
                                               ])
                                               type="text" id="name" name="name" required
                                               value="{{ old('name', $user['name'] ?? '') }}"
                                               placeholder="Name...">
                                        @error('name')
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
                                               type="text" id="email" name="email" required
                                               value="{{ old('email', $user['email'] ?? '') }}"
                                               placeholder="Email...">
                                        @error('email')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="password" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Password
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('password'),
                                                   "border-red-500" => $errors->first('password'),
                                               ])
                                               type="password" id="password" name="password" @required($add)
                                               placeholder="Password...">
                                        @error('password')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="password_confirmation" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Confirm Password
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('password_confirmation'),
                                                   "border-red-500" => $errors->first('password_confirmation'),
                                               ])
                                               type="password" id="password_confirmation" name="password_confirmation" @required($add)
                                               placeholder="Confirm password...">
                                        @error('password_confirmation')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
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
                                               type="text" id="phone" name="phone"
                                               value="{{ old('phone', $user['phone'] ?? '') }}"
                                               placeholder="Phone...">
                                        @error('phone')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="role" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Role
                                        </label>
                                        @php $old = old('role', $user['role_id'] ?? ''); @endphp
                                        <select @class([
                                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                       "border-slate-300" => !$errors->first('role'),
                                                       "border-red-500" => $errors->first('role'),
                                                   ])
                                                id="role" name="role" required>
                                            @if ($user_id != 1)
                                                <option value="">Choose...</option>
                                            @endif
                                            @foreach ($roles as $role)
                                                @continue($user_id == 1 && $role['id'] != 1)
                                                <option value="{{ $role['id'] }}" @selected($role['id'] == $old)>
                                                    {{ $role['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="status" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Status
                                        </label>
                                        @php $old = old('status', $user['active'] ?? 1); @endphp
                                        <select @class([
                                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                       "border-slate-300" => !$errors->first('status'),
                                                       "border-red-500" => $errors->first('status'),
                                                   ])
                                                id="status" name="status">
                                            <option value="1" @selected($old)>Active</option>
                                            @if ($user_id != 1)
                                            <option value="" @selected(!$old)>Inactive</option>
                                            @endif
                                        </select>
                                        @error('status')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ $add ? '+ Add' : 'Update' }} User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
