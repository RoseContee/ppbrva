<x-guest-layout>
    <form method="POST" action="{{ route('scan.store') }}" enctype="multipart/form-data" class="px-5">
        @csrf

        @if (!empty($member))
            <div class="text-center mt-4 mb-5">
                <img src="{{ $member['avatar'] }}" alt="Avatar" class="w-48 rounded-full mb-4 mx-auto"/>
                <h1 class="text-2xl mb-1">{{ $member['name'] }}</h1>
                <h2 class="text-xl text-slate-500 capitalize mb-5">
                    {{ $member['gender'] }}, {{ \Carbon\Carbon::parse($member['dob'])->age }}
                </h2>
                <span class="text-lg bold text-green-600 border border-thin rounded py-2 px-4">
                    ACTIVE
                </span>
            </div>
        @elseif (!empty($error))
            <div class="text-center mt-4 mb-5">
                <img src="{{ asset('img/notfound.svg') }}" alt="Not found" class="w-48 mb-4 mx-auto"/>
                <h1 class="text-2xl mb-5">NOT FOUND</h1>
                <span class="text-lg bold text-red-600 border border-thin rounded py-2 px-4">
                    ERROR
                </span>
            </div>
        @endif
        <br /><br />
        <div class="text-center pt-50">
            <input type="text" name="card_id" value="{{ request()->card_id }}" required autofocus/>
            <x-primary-button class="mx-auto">
                {{ __('Scan') }}
            </x-primary-button>
        </div>
        <br />
        <div class="text-center">
            <a href="{{ route('scan.index') }}" class="text-blue-500 underline">Reset</a>
        </div>
    </form>

    @push ('scripts')
        <script>
            document.onkeypress = function (e) {
                e = e || window.event;
                console.log(e);
                // use e.keyCode
            };
        </script>
    @endpush
</x-guest-layout>
