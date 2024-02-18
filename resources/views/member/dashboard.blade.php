<x-member-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-grange-demi-bold text-2xl text-title mb-3">
                        {{ __('Dashboard') }}
                    </h2>
                    <p>Welcome back {{ $member['name'] }}!</p>
                </div>

                <div class="w-full px-5 py-5">
                    @if (!$member['card_last4'])
                        <div class="message p-3 mb-3">
                            Please update your
                            <a href="{{ route('member.profile.billing') }}" class="text-blue underline">
                                billing profile
                            </a>
                            <a class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3"
                               href="{{ route('member.profile.billing') }}">
                                FIX
                            </a>
                        </div>
                    @endif
                    <div class="-mx-2 md:flex">
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl p-4 mb-4 text-center">
                                <a href="{{ $dashboard['play_link'] }}">
                                    <img src="{{ $dashboard['play_icon'] }}" alt="Play" class="w-full mb-3">
                                    <span class="font-grange-demi-bold text-xl text-gray">Play</span>
                                </a>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl p-4 mb-4 text-center">
                                <a href="{{ $dashboard['improve_link'] }}">
                                    <img src="{{ $dashboard['improve_icon'] }}" alt="Improve" class="w-full mb-3">
                                    <span class="font-grange-demi-bold text-xl text-gray">Improve</span>
                                </a>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl p-4 mb-4 text-center">
                                <a href="{{ $dashboard['rent_link'] }}">
                                    <img src="{{ $dashboard['rent_icon'] }}" alt="Rent" class="w-full mb-3">
                                    <span class="font-grange-demi-bold text-xl text-gray">Rent</span>
                                </a>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl p-4 mb-4 text-center">
                                <a href="{{ $dashboard['shop_link'] }}">
                                    <img src="{{ $dashboard['shop_icon'] }}" alt="Shop" class="w-full mb-3">
                                    <span class="font-grange-demi-bold text-xl text-gray">Shop</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl p-4">
                        <a href="{{ route('member.profile.billing') }}" class="flex justify-between items-center">
                            <div>
                                <h4 class="font-grange-demi-bold text-xl text-primary">
                                    {{ $member['plan']['name'] ?? 'Unknown' }}
                                </h4>
                                <p class="">Member #{{ $member['memberID'] }}</p>
                            </div>
                            <img src="{{ $member['avatar'] }}" alt="Avatar" class="w-20 h-20 rounded-full">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-member-app-layout>
