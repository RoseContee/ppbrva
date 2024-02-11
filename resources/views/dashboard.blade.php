<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Dashboard') }}
                    </h2>
                </div>

                <div class="w-full px-3 py-5 mb-6">
                    <div class="-mx-2 md:flex">
                        <div class="md:w-1/3 px-2">
                            <canvas id="plan-chart"></canvas>
                        </div>
                        <div class="md:w-1/3 px-2">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-2">
                                <tbody>
                                    @foreach ($plans as $i => $plan)
                                        <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="p-2">
                                                <div class="w-4 h-4" style="background: {{ $colors[$i % count($colors)] }};"></div>
                                            </td>
                                            <td class="p-2">{{ $plan['name'] }}</td>
                                            <td class="p-2">{{ $plan['members_count'] }}</td>
                                            <td class="p-2">${{ number_format($plan['members_count'] * $plan['price'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="md:w-1/3 px-2">
                            <div class="md:flex">
                                <div class="w-full px-2">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 py-5 mb-4 text-center">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Active</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight mt-3 mb-0">
                                            {{ $active_members }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="w-full px-2">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 py-5 mb-4 text-center">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Paused</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight mt-3 mb-0">
                                            {{ $paused_members }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="md:flex">
                                <div class="w-full px-2">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 py-5 mb-4 text-center">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Suspended</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight mt-3 mb-0">
                                            {{ $suspended_members }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="w-full px-2">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 py-5 mb-4 text-center">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Inactive</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight mt-3 mb-0">
                                            {{ $inactive_members }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="md:flex">
                                <div class="w-full px-2">
                                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 py-5 mb-4 text-center">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Pending</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight mt-3 mb-0">
                                            {{ $pending_members }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="w-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="daterange-picker" class="md:flex items-end bg-white dark:bg-gray-900 px-5 pt-6"
                      action="{{ route('dashboard') }}" method="GET">
                    <div class="relative">
                        <label for="start-date" class="block tracking-wide text-gray-900 text-xs mb-1">
                            Start Date
                        </label>
                        <input @class([
                                   "w-full block p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",
                                   "border-slate-300" => !$errors->first('start_date'),
                                   "border-red-500" => !$errors->first('start_date'),
                               ])
                               type="text" id="start-date" name="s" autocomplete="off"
                               value="{{ old('s', $s) }}"
                               placeholder="Start Date...">
                    </div>
                    <div class="relative md:mx-3 mt-3 md:mt-0">
                        <label for="end-date" class="block tracking-wide text-gray-900 text-xs mb-1">
                            End Date
                        </label>
                        <input @class([
                                       "w-full block p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",
                                       "border-slate-300" => !$errors->first('end_date'),
                                       "border-red-500" => !$errors->first('end_date'),
                               ])
                               type="text" id="end-date" name="e" autocomplete="off"
                               value="{{ old('e', $e) }}"
                               placeholder="End Date...">
                    </div>
                    <div class="relative">
                        <label class="block tracking-wide text-gray-900 text-xs mb-1">&nbsp;</label>
                        <button class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                type="submit">
                            Apply
                        </button>
                    </div>
                </form>

                <div class="w-full px-5 py-5">
                    <div class="-mx-2 md:flex">
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 pt-8 pb-10 mb-4 text-center">
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Dues</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">
                                    ${{ number_format($dues) }}
                                </h3>
                                <p @class([
                                        "text-xs leading-tight",
                                        "text-green-500" => $dues_percent >= 0,
                                        "text-red-500" => $dues_percent < 0,
                                   ])>
                                    {{ $dues_percent >= 0 ? '▲' : '▼' }} {{ $dues_percent }}%
                                </p>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 pt-8 pb-10 mb-4 text-center">
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Food & Beverage</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">
                                    ${{ number_format($food_beverage) }}
                                </h3>
                                <p @class([
                                        "text-xs leading-tight",
                                        "text-green-500" => $food_beverage_percent >= 0,
                                        "text-red-500" => $food_beverage_percent < 0,
                                   ])>
                                    {{ $food_beverage_percent >= 0 ? '▲' : '▼' }} {{ $food_beverage_percent }}%
                                </p>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 pt-8 pb-10 mb-4 text-center">
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Lessons</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">
                                    ${{ number_format($lessons) }}
                                </h3>
                                <p @class([
                                        "text-xs leading-tight",
                                        "text-green-500" => $lessons_percent >= 0,
                                        "text-red-500" => $lessons_percent < 0,
                                   ])>
                                    {{ $lessons_percent >= 0 ? '▲' : '▼' }} {{ $lessons_percent }}%
                                </p>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 pt-8 pb-10 mb-4 text-center">
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Rentals</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">
                                    ${{ number_format($rentals) }}
                                </h3>
                                <p @class([
                                        "text-xs leading-tight",
                                        "text-green-500" => $rentals_percent >= 0,
                                        "text-red-500" => $rentals_percent < 0,
                                   ])>
                                    {{ $rentals_percent >= 0 ? '▲' : '▼' }} {{ $rentals_percent }}%
                                </p>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 pt-8 pb-10 mb-4 text-center">
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Merchandise</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">
                                    ${{ number_format($merchandise) }}
                                </h3>
                                <p @class([
                                        "text-xs leading-tight",
                                        "text-green-500" => $merchandise_percent >= 0,
                                        "text-red-500" => $merchandise_percent < 0,
                                   ])>
                                    {{ $merchandise_percent >= 0 ? '▲' : '▼' }} {{ $merchandise_percent }}%
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="md:flex">
                        <div class="mt-8 px-4 md:w-70">
                            <canvas id="payment-chart"></canvas>
                        </div>
                        <div class="mt-8 px-4 md:w-30">
                            <canvas id="pie-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            new Chart(document.getElementById('plan-chart'), {
                type: 'pie',
                data: {
                    labels: [@foreach ($plans as $plan) '{{ $plan['name'] }}', @endforeach],
                    datasets: [{
                        data: [@foreach ($plans as $plan) {{ $plan['price'] * $plan['members_count'] }}, @endforeach],
                        members: [@foreach ($plans as $plan) {{ $plan['members_count'] }}, @endforeach],
                        backgroundColor: [@foreach ($plans as $i => $plan) '{{ $colors[$i % count($colors)] }}', @endforeach],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: context => {
                                    const dataset = context.dataset;
                                    const dataIndex = context.dataIndex;
                                    const label = `${dataset.members[dataIndex]} = `;
                                    return `${label} $${context.formattedValue}`;
                                }
                            }
                        }
                    }
                },
            });

            new DateRangePicker(document.getElementById('daterange-picker'));

            new Chart(document.getElementById('payment-chart'), {
                type: 'bar',
                data: {
                    labels: [@foreach ($plotting_payments as $label => $value)'{{ $label }}',@endforeach],
                    datasets: [{
                        label: 'Payments',
                        data: [@foreach ($plotting_payments as $value){{ $value }},@endforeach],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => `$${value}`,
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: context => `${context.dataset.label}: $${context.formattedValue}`,
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('pie-chart'), {
                type: 'pie',
                data: {
                    labels: ['Dues', 'Food & Beverage', 'Lessons', 'Rentals', 'Merchandise'],
                    datasets: [{
                        data: [{{ $dues }}, {{ $food_beverage }}, {{ $lessons }}, {{ $rentals }}, {{ $merchandise }}],
                        backgroundColor: [@for ($i = 0; $i < 5; $i++) '{{ $colors[$i % count($colors)] }}', @endfor],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: context => `$${context.formattedValue}`,
                            }
                        }
                    }
                },
            });
        </script>
    @endpush
</x-app-layout>
