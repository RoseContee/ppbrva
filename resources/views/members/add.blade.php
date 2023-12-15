@php
$add = empty($member);
$route = $add ? route('members.store') : route('members.update', $member['id']);
@endphp

<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ $add ? 'Add' : 'Edit' }} Member @if (!$add) #{{ $member['memberID'] }} @endif
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
                                        <label for="firstname" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            First Name
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('firstname'),
                                                   "border-red-500" => $errors->first('firstname'),
                                               ])
                                               type="text" id="firstname" name="firstname" required
                                               value="{{ old('firstname', $member['firstname'] ?? '') }}"
                                               placeholder="First Name...">
                                        @error('firstname')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="lastname" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Last Name
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('lastname'),
                                                   "border-red-500" => $errors->first('lastname'),
                                               ])
                                               type="text" id="lastname" name="lastname" required
                                               value="{{ old('lastname', $member['lastname'] ?? '') }}"
                                               placeholder="Last Name...">
                                        @error('lastname')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="gender" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Gender
                                        </label>
                                        <select @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('gender'),
                                                   "border-red-500" => $errors->first('gender'),
                                                ])
                                                id="gender" name="gender" required>
                                            @php $old = old('gender', $member['gender'] ?? ''); @endphp
                                            <option value="">Choose...</option>
                                            <option value="male" @selected($old == 'male')>
                                                Male
                                            </option>
                                            <option value="female" @selected($old == 'female')>
                                                Female
                                            </option>
                                            <option value="prefer_not_to_say" @selected($old === 'prefer_not_to_say')>
                                                Prefer not to say
                                            </option>
                                        </select>
                                        @error('gender')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="email" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Email
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('email'),
                                                   "border-red-500" => $errors->first('email'),
                                               ])
                                               type="email" id="email" name="email" required
                                               value="{{ old('email', $member['email'] ?? '') }}"
                                               placeholder="Email...">
                                        @error('email')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="phone" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Phone
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('phone'),
                                                   "border-red-500" => $errors->first('phone'),
                                               ])
                                               type="text" id="phone" name="phone"
                                               value="{{ old('phone', $member['phone'] ?? '') }}"
                                               placeholder="Phone...">
                                        @error('phone')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="dob" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Date of Birth
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('dob'),
                                                   "border-red-500" => $errors->first('dob'),
                                               ])
                                               type="text" id="dob" name="dob" required
                                               value="{{ old('dob', !empty($member['dob']) ? date('m/d/Y', strtotime($member['dob'])) : '') }}"
                                               autocomplete="off"
                                               placeholder="MM/DD/YYYY">
                                        @error('dob')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="address" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Address
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('address'),
                                                   "border-red-500" => $errors->first('address'),
                                               ])
                                               type="text" id="address" name="address" required
                                               value="{{ old('address', $member['address'] ?? '') }}"
                                               placeholder="Address...">
                                        @error('address')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="city" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            City
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('city'),
                                                   "border-red-500" => $errors->first('city'),
                                               ])
                                               type="text" id="city" name="city" required
                                               value="{{ old('city', $member['city'] ?? '') }}"
                                               placeholder="City...">
                                        @error('city')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="state" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            State
                                        </label>
                                        <select @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('state'),
                                                   "border-red-500" => $errors->first('state'),
                                                ])
                                                id="state" name="state" required>
                                            <option value="">Choose...</option>
                                            @foreach ($states as $key => $state)
                                                <option value="{{ $key }}" @selected(old('state', $member['state'] ?? '') == $key)>
                                                    {{ $state }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('state')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="zipcode" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Zip Code
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('zipcode'),
                                                   "border-red-500" => $errors->first('zipcode'),
                                               ])
                                               type="text" id="zipcode" name="zipcode" required
                                               value="{{ old('zipcode', $member['zipcode'] ?? '') }}"
                                               placeholder="Zip Code...">
                                        @error('zipcode')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="location" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Location
                                        </label>
                                        @php $old = old('location', $member['location_id'] ?? ''); @endphp
                                        <select @class([
                                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                       "border-slate-300" => !$errors->first('location'),
                                                       "border-red-500" => $errors->first('location'),
                                                   ])
                                                id="location" name="location" required>
                                            <option value="">Choose...</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location['id'] }}" @selected($location['id'] == $old)>
                                                    {{ $location['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                    <label for="plan" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Membership Plan
                                    </label>
                                        @php $old = old('plan', $member['plan_id'] ?? ''); @endphp
                                        <select @class([
                                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                       "border-slate-300" => !$errors->first('plan'),
                                                       "border-red-500" => $errors->first('plan'),
                                                   ])
                                                id="plan" name="plan" required>
                                            <option value="">Choose...</option>
                                            @foreach ($plans as $plan)
                                                <option value="{{ $plan['id'] }}" @selected($plan['id'] == $old)>
                                                    {{ $plan['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="membership_card_id" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Membership Card ID
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('membership_card_id'),
                                                   "border-red-500" => $errors->first('membership_card_id'),
                                               ])
                                               type="text" id="membership_card_id" name="membership_card_id"
                                               value="{{ old('membership_card_id', $member['membership_card_id'] ?? '') }}"
                                               placeholder="Membership Card ID...">
                                        @error('membership_card_id')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                @if (!$add && $member['status'] != 'pending')
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        <div class="w-full px-3">
                                            <label for="status" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                                Status
                                            </label>
                                            @php $old = old('status', $member['status']); @endphp
                                            <select @class([
                                                           "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                           "border-slate-300" => !$errors->first('status'),
                                                           "border-red-500" => $errors->first('status'),
                                                       ])
                                                    id="status" name="status" required>
                                                <option value="active" @selected($old == 'active')>Active</option>
                                                <option value="inactive" @selected($old == 'inactive')>Inactive</option>
                                            </select>
                                            @error('status')
                                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ $add ? '+ Add' : 'Update' }} Member
                                </button>
                            </div>

                            <div class="w-full max-w-lg">
                                <div class="justify-center" :class="{'flex': avatar, 'hidden': !avatar}">
                                    <img :src="avatar" alt="Avatar"
                                         class="w-96 mb-5" />
                                </div>
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="avatar" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Upload Avatar
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('avatar'),
                                                   "border-red-500" => $errors->first('avatar'),
                                               ])
                                               type="file" id="avatar" name="avatar"
                                               accept="image/*"
                                               v-on:change="selectAvatar"
                                               placeholder="Choose Image...">
                                        @error('avatar')
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

    @push('scripts')
        <script type="module">
            const { createApp, ref, computed } = Vue

            createApp({
                setup() {
                    const original_avatar = '{{ $add || !$member['avatar'] ? '' : asset($member['avatar']) }}';
                    const avatar = ref(original_avatar);
                    const selectAvatar = e => {
                        const files = e.target.files;
                        if (!files.length) {
                            avatar.value = original_avatar;
                            return;
                        }
                        const fr = new FileReader();
                        fr.onload = () => {
                            avatar.value = fr.result;
                        };
                        fr.readAsDataURL(files[0]);
                    }

                    return {
                        avatar,
                        selectAvatar
                    }
                },
                mounted() {
                    new Datepicker(document.getElementById('dob'), {
                        autohide: true,
                    });
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
