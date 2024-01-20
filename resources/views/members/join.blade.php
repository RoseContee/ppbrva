<x-guest-layout>
    <form id="app" class="px-5" method="POST" action="{{ route('members.join') }}">
        @csrf
        <!-- Plan Type -->
        <div class="mt-4">
            <label for="plan" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Membership Plan
            </label>
            <select @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('plan'),
                       "border-red-500" => $errors->first('plan'),
                    ])
                    id="plan" name="plan" required>
                <option value="">Choose...</option>
                @foreach ($plans as $plan)
                    <option value="{{ $plan['id'] }}" @selected($plan['id'] == old('plan'))>
                        {{ $plan['name'] }}
                    </option>
                @endforeach
            </select>
            @error('plan')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- First Name -->
        <div class="mt-4">
            <label for="firstname" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                First Name
            </label>
            <input @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('firstname'),
                       "border-red-500" => $errors->first('firstname'),
                   ])
                   type="text" id="firstname" name="firstname" required
                   value="{{ old('firstname') }}"
                   placeholder="First Name...">
            @error('firstname')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <label for="lastname" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                Last Name
            </label>
            <input @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('lastname'),
                       "border-red-500" => $errors->first('lastname'),
                   ])
                   type="text" id="lastname" name="lastname" required
                   value="{{ old('lastname') }}"
                   placeholder="Last Name...">
            @error('lastname')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <label for="gender" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Gender
            </label>
            <select @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('gender'),
                       "border-red-500" => $errors->first('gender'),
                    ])
                    id="gender" name="gender" required>
                <option value="">Choose...</option>
                <option value="male" @selected(old('gender') == 'male')>
                    Male
                </option>
                <option value="female" @selected(old('gender') == 'female')>
                    Female
                </option>
                <option value="prefer_not_to_say" @selected(old('gender') === 'prefer_not_to_say')>
                    Prefer not to say
                </option>
            </select>
            @error('gender')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                Email
            </label>
            <input @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('email'),
                       "border-red-500" => $errors->first('email'),
                   ])
                   type="email" id="email" name="email" required
                   value="{{ old('email') }}"
                   placeholder="Email...">
            @error('email')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <label for="phone" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Phone
            </label>
            <input @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('phone'),
                       "border-red-500" => $errors->first('phone'),
                   ])
                   type="text" id="phone" name="phone" required
                   value="{{ old('phone') }}"
                   placeholder="Phone...">
            @error('phone')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>


        <!-- Date of Birth -->
        <div class="mt-4">
            <label for="dob" class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2">
                Date of Birth
            </label>
            <input @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('dob'),
                       "border-red-500" => $errors->first('dob'),
                   ])
                   type="text" id="dob" name="dob" required
                   value="{{ old('dob') }}"
                   autocomplete="off"
                   placeholder="MM/DD/YYYY">
            @error('dob')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Address -->
        <div class="mt-4">
            <label for="address" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Address
            </label>
            <input @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('address'),
                       "border-red-500" => $errors->first('address'),
                   ])
                   type="text" id="address" name="address" required
                   value="{{ old('address') }}"
                   placeholder="Address...">
            @error('address')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- City -->
        <div class="mt-4">
            <label for="city" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                City
            </label>
            <input @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('city'),
                       "border-red-500" => $errors->first('city'),
                   ])
                   type="text" id="city" name="city" required
                   value="{{ old('city') }}"
                   placeholder="City...">
            @error('city')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- State  -->
        <div class="mt-4 w-1/2">
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
                    <option value="{{ $key }}" @selected(old('state') == $key)>{{ $state }}</option>
                @endforeach
            </select>
            @error('state')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Zip Code -->
        <div class="mt-4 w-1/2">
            <label for="zipcode" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Zip Code
            </label>
            <input @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('zipcode'),
                       "border-red-500" => $errors->first('zipcode'),
                   ])
                   type="text" id="zipcode" name="zipcode" required
                   value="{{ old('zipcode') }}"
                   placeholder="Zip Code...">
            @error('zipcode')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Location -->
        <div class="mt-4">
            <label for="location" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Location
            </label>
            <select @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('location'),
                       "border-red-500" => $errors->first('location'),
                    ])
                    id="location" name="location" required>
                @foreach ($locations as $location)
                    <option value="{{ $location['id'] }}" @selected($location['id'] == old('location'))>
                        {{ $location['name'] }}
                    </option>
                @endforeach
            </select>
            @error('location')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- DUPR ID -->
        <div class="mt-4">
            <label for="dupr_id" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                DUPR ID
            </label>
            <input @class([
                       "appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white",
                       "border-slate-300" => !$errors->first('dupr_id'),
                       "border-red-500" => $errors->first('dupr_id'),
                   ])
                   type="text" id="dupr_id" name="dupr_id"
                   value="{{ old('dupr_id') }}"
                   placeholder="DUPR ID...">
            @error('dupr_id')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Disclaimer -->
        <div class="mt-4">
            <p><strong>DISCLAIMER:</strong></p>
            <p>Membership signups are being offered in anticipation of our initial opening in late 2023. Members will be notified as our opening date approaches.</p>
        </div>

        <!-- Agree -->
        <div class="mt-4">
            <div class="flex items-center">
                <input type="checkbox" id="agree" name="agree" value="1" v-model="agree" required />
                <label for="agree" class="font-medium text-sm text-gray-700 ml-2">
                    Please check to agree to the above site terms of use.
                </label>
            </div>
            @error('agree')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4"
                    :class="{'bg-blue': agree, 'bg-cyan-100': !agree}" :disabled="!agree">
                Register
            </button>
        </div>
    </form>

    @push ('scripts')
        <script type="module">
            const { createApp, ref, computed } = Vue;

            createApp({
                setup() {
                    const agree = ref(false);

                    return {
                        agree,
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
</x-guest-layout>
