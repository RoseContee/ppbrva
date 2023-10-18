<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Settings') }}
                    </h2>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                        <ul class="list-disc m-5">
                            <li>
                                <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                   href="{{ route('settings.plans.index') }}">
                                    Manage Plans
                                </a>
                            </li>
                            <li class="py-2">
                                <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                   href="{{ route('settings.roles.index') }}">
                                    Manage Roles
                                </a>
                            </li>
                            <li>
                                <a class="font-medium text-blue underline dark:text-blue-500 hover:no-underline hover:text-gray"
                                   href="{{ route('settings.appicons.index') }}">
                                    Dashboard Icons
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
