<x-app-layout>
    @push ('styles')
        <style>
            @media (min-width: 768px) {
                .md\:w-70 {
                    width: 70%;
                }
                .md\:w-30 {
                    width: 30%;
                }
            }
        </style>
    @endpush

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Dashboard') }}
                    </h2>
                </div>

                <form id="daterange-picker" class="flex items-end justify-end bg-white dark:bg-gray-900 px-3"
                      action="" method="GET">
                    <div class="relative">
                        <label for="start-date" class="block tracking-wide text-gray-900 text-xs mb-1">
                            Start Date
                        </label>
                        <input @class([
                                   "block p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",
                                   "border-slate-300" => !$errors->first('start_date'),
                                   "border-red-500" => !$errors->first('start_date'),
                               ])
                               type="text" id="start-date" name="s" autocomplete="off"
                               value="{{ old('s', $s) }}"
                               placeholder="Start Date...">
                    </div>
                    <div class="relative mx-3">
                        <label for="end-date" class="block tracking-wide text-gray-900 text-xs mb-1">
                            End Date
                        </label>
                        <input @class([
                                       "block p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",
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
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Members</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">
                                    {{ $members }}
                                </h3>
                                <p @class([
                                        "text-xs leading-tight",
                                        "text-green-500" => $members_percent >= 0,
                                        "text-red-500" => $members_percent < 0,
                                   ])>
                                    {{ $members_percent >= 0 ? '▲' : '▼' }} {{ $members_percent }}%
                                </p>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg bg-white shadow-lg md:shadow-xl px-3 pt-8 pb-10 mb-4 text-center">
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Payments</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">
                                    ${{ number_format($payments) }}
                                </h3>
                                <p @class([
                                        "text-xs leading-tight",
                                        "text-green-500" => $payments_percent >= 0,
                                        "text-red-500" => $payments_percent < 0,
                                   ])>
                                    {{ $payments_percent >= 0 ? '▲' : '▼' }} {{ $payments_percent }}%
                                </p>
                            </div>
                        </div>
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
                                callback: value => '$' + value,
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: context => {
                                    let label = context.dataset.label || '';
                                    if (label) label += ': ';
                                    if (context.parsed.y !== null) {
                                        label += '$' + context.parsed.y;
                                    }
                                    return label;
                                }
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
                        backgroundColor: ['#4bc0c0', '#36a2eb', '#ff6384', '#ff9f40', '#ffcd56'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: context => {
                                    if (context.parsed !== null) {
                                        return '$' + context.parsed;
                                    }
                                    return '';
                                }
                            }
                        }
                    }
                },
            });
        </script>
    @endpush
</x-app-layout>
