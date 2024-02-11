<x-member-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Invoice #{{ $invoice['invoiceID'] }}
                    </h2>

                    <x-messages />

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-4">
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900">
                            <div class="font-normal text-gray-500">{{ $invoice['period'] }}</div>
                            <a class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                               href="{{ route('invoices.download', $invoice['id']) }}">
                                Download PDF
                            </a>
                        </div>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-zinc-100 text-navy">
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">Detail</th>
                                    <th scope="col" class="px-6 py-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice['activities'] as $activity)
                                    <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white text-base font-semibold">
                                            {{ $activity['category'] . ' ' . date('n/j', strtotime($activity['date'])) }}
                                            @if ($activity['member_id'] != $invoice['member_id'])
                                                ({{ $activity['member']['name'] ?? 'SECONDARY ACCOUNT' }})
                                            @endif
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ ($activity['from'] == 'clover' ? '#' : '').$activity['detail'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            ${{ number_format($activity['price'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($invoice['plans'] as $plan)
                                    <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white text-base font-semibold">
                                            Membership Dues
                                        </th>
                                        <td class="px-6 py-4">
                                            @if ($plan['member_id'] == $invoice['member_id'])
                                                {{ $plan['name'] }}
                                            @else
                                                {{ $plan['member']['name'] ?? 'SECONDARY ACCOUNT' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            ${{ number_format($plan['price'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white text-base font-semibold">
                                        TOTAL
                                    </th>
                                    <td class="px-6 py-4"></td>
                                    <td class="px-6 py-4">
                                        ${{ number_format($invoice['amount'], 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if ($invoice['paid'])
                            <p class="text-center m-6">
                                Paid on {{ date('n/j/y @ h:i A', strtotime($invoice['paid_at'])) }}
                                using {{ strtoupper($invoice['card_type']) }} ending in ****{{ $invoice['card_last4'] }}
                            </p>
                        @else
                            <div class="flex justify-center m-6">
                                <p class="flex items-center mr-3">
                                    <b class="mr-1">Unpaid Reason:</b>
                                    {{ $invoice['reason'] ?? 'Unknown' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-member-app-layout>
