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
                        <form class="flex justify-between p-4 bg-white dark:bg-gray-900"
                              action="{{ $route }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (!$add)
                                @method('PUT')
                            @endif
                            <div class="w-full max-w-lg">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="plan" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Membership Plan
                                        </label>
                                        @php $old_plan = old('plan', $member['plan_id'] ?? ''); @endphp
                                        <select @class([
                                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                       "border-slate-300" => !$errors->first('plan'),
                                                       "border-red-500" => $errors->first('plan'),
                                                   ])
                                                id="plan" name="plan" v-model="plan" required>
                                            <option value="">Choose...</option>
                                            @foreach ($plans as $plan)
                                                <option value="{{ $plan['id'] }}"
                                                    @selected($old_plan == $plan['id'])>
                                                    {{ $plan['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6"
                                     :class="{'hidden': plan !== '{{ $family_plan_id }}'}">
                                    <div class="w-full px-3">
                                        <label for="family_type" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Family Member Type
                                        </label>
                                        @php
                                            if (($member['plan_id'] ?? '') == $family_plan_id) {
                                                $old_family_type = empty($member['primary_id']) ? 'primary' : 'secondary';
                                            }
                                            $old_family_type = old('family_type', $old_family_type ?? '');
                                        @endphp
                                        <select @class([
                                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                       "border-slate-300" => !$errors->first('family_type'),
                                                       "border-red-500" => $errors->first('family_type'),
                                                   ])
                                                id="family_type" name="family_type"
                                                v-model="family_type" :required="plan === '{{ $family_plan_id }}'">
                                            <option value="">Choose...</option>
                                            <option value="primary" @selected($old_family_type === 'primary')>Primary</option>
                                            <option value="secondary" @selected($old_family_type === 'secondary')>Secondary</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6"
                                     :class="{'hidden': plan !== '{{ $family_plan_id }}' || family_type !== 'secondary'}">
                                    <div class="w-full px-3">
                                        <label for="primary_account" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                            Assign Primary Account
                                        </label>
                                        <select @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('primary_account'),
                                                   "border-red-500" => $errors->first('primary_account'),
                                               ])
                                                id="primary_account" name="primary_account"
                                                :required="plan === '{{ $family_plan_id }}' && family_type === 'secondary'">
                                            <option value="">Please select a primary member...</option>
                                            @foreach ($primary_members as $m)
                                                <option value="{{ $m['id'] }}"
                                                    @selected(old('primary_account', $member['primary_id'] ?? '') == $m['id'])>
                                                    {{ $m['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('primary_account')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6"
                                     :class="{'hidden': plan !== '{{ $family_plan_id }}' || family_type !== 'secondary'}">
                                    <div class="w-full px-3">
                                        <label for="is_child" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Is Child
                                        </label>
                                        <select @class([
                                                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                       "border-slate-300" => !$errors->first('is_child'),
                                                       "border-red-500" => $errors->first('is_child'),
                                                   ])
                                                id="is_child" name="is_child">
                                            <option value="">No</option>
                                            <option value="1" @selected(old('is_child', $member['is_child'] ?? ''))>Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-wrap -mx-3 mb-6"
                                     :class="{'hidden': plan !== '{{ $family_plan_id }}' || family_type !== 'secondary'}">
                                    <div class="w-full px-3">
                                        <label for="additional_monthly_fee" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Additional Monthly Fee
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('additional_monthly_fee'),
                                                   "border-red-500" => $errors->first('additional_monthly_fee'),
                                               ])
                                               type="number" id="additional_monthly_fee" name="additional_monthly_fee"
                                               value="{{ old('additional_monthly_fee', $member['secondary_fee'] ?? '') }}"
                                               placeholder="Additional Monthly Fee...">
                                        @error('additional_monthly_fee')
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
                                                id="gender" name="gender">
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
                                               type="text" id="dob" name="dob"
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
                                               type="text" id="address" name="address"
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
                                               type="text" id="city" name="city"
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
                                                id="state" name="state">
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
                                               type="text" id="zipcode" name="zipcode"
                                               value="{{ old('zipcode', $member['zipcode'] ?? '') }}"
                                               placeholder="Zip Code...">
                                        @error('zipcode')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
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

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="dupr_id" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            DUPR ID
                                        </label>
                                        <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('dupr_id'),
                                                   "border-red-500" => $errors->first('dupr_id'),
                                               ])
                                               type="text" id="dupr_id" name="dupr_id"
                                               value="{{ old('dupr_id', $member['profile']['dupr_id'] ?? '') }}"
                                               placeholder="DUPR ID...">
                                        @error('dupr_id')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                @if (!($pending_member = $add || $member['status'] == 'pending'))
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        <div class="w-full px-3">
                                            <label for="status" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                                Status
                                            </label>
                                            <select @class([
                                                           "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                           "border-slate-300" => !$errors->first('status'),
                                                           "border-red-500" => $errors->first('status'),
                                                       ])
                                                    id="status" name="status" v-model="status" required>
                                                <option value="active">Active</option>
                                                <option value="paused">Paused</option>
                                                <option value="suspended">Suspend</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            @error('status')
                                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap -mx-3 mb-6" :class="{'hidden': status !== 'paused'}">
                                        <div class="w-full px-3">
                                            <label for="pause_from" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                                Pause From
                                            </label>
                                            <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('pause_from'),
                                                   "border-red-500" => $errors->first('pause_from'),
                                               ])
                                                   type="text" id="pause_from" name="pause_from" :required="status === 'paused'"
                                                   value="{{ old('pause_from', !empty($member['pause_from']) ? date('m/d/Y', strtotime($member['pause_from'])) : '') }}"
                                                   autocomplete="off"
                                                   placeholder="MM/DD/YYYY">
                                            @error('pause_from')
                                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap -mx-3 mb-6" :class="{'hidden': status !== 'paused'}">
                                        <div class="w-full px-3">
                                            <label for="pause_to" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                                                Pause To
                                            </label>
                                            <input @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('pause_to'),
                                                   "border-red-500" => $errors->first('pause_to'),
                                               ])
                                                   type="text" id="pause_to" name="pause_to" :required="status === 'paused'"
                                                   value="{{ old('pause_to', !empty($member['pause_to']) ? date('m/d/Y', strtotime($member['pause_to'])) : '') }}"
                                                   autocomplete="off"
                                                   placeholder="MM/DD/YYYY">
                                            @error('pause_to')
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

                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label for="note" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                            Note
                                        </label>
                                        <textarea @class([
                                                   "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                                                   "border-slate-300" => !$errors->first('note'),
                                                   "border-red-500" => $errors->first('note'),
                                               ])
                                               type="text" id="note" name="note" rows="7"
                                               placeholder="Notes...">{{ old('note', $member['note'] ?? '') }}</textarea>
                                        @error('note')
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
                    const plan = ref('{{ $old_plan }}');
                    const family_type = ref('{{ $old_family_type }}');
                    const original_avatar = '{{ $member['avatar'] ?? '' }}';
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
                    @if (!$pending_member)
                        const status = ref('{{ old('status', $member['status']) }}');
                    @endif

                    return {
                        plan, family_type,
                        avatar, selectAvatar,
                        @if (!$pending_member)
                            status,
                        @endif
                    }
                },
                mounted() {
                    new Datepicker(document.getElementById('dob'), {
                        autohide: true,
                    });
                    new Choices(document.querySelector('#primary_account'), {
                        allowHTML: true,
                        placeholder: true,
                        searchPlaceholderValue: 'Find primary member',
                        noResultsText: 'No primary members found',
                        itemSelectText: '',
                        classNames: {
                            containerOuter: 'choices m-0',
                            containerInner: 'choices--inner '
                                + 'appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white'
                                + '@if(!$errors->first('primary_account')) border-slate-300 @else border-red-500 @endif',
                            listSingle: '',
                        }
                    });
                    @if (!$pending_member)
                        new Datepicker(document.getElementById('pause_from'), {
                            autohide: true,
                        });
                        new Datepicker(document.getElementById('pause_to'), {
                            autohide: true,
                        });
                    @endif
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
