<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Invoice #{{ $invoice['invoiceID'] }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css'])
    <style>
        .vertical-middle {
            vertical-align: middle;
        }
        .vertical-bottom {
            vertical-align: bottom;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <h2 class="font-semibold text-xl leading-tight mb-6">
        Invoice #{{ $invoice['invoiceID'] }}
    </h2>

    <table class="w-full mb-2">
        <tbody>
        <tr>
            <td class="w-10">
                <img class="w-10 h-10 rounded-full"
                     src="{{ $invoice['member']['avatar'] }}"
                     alt="{{ $invoice['member']['name'] }}">
            </td>
            <td class="text-base font-medium vertical-middle pl-3">
                {{ $invoice['member']['name'] }}
            </td>
            <td class="font-normal vertical-bottom text-right">
                {{ $invoice['period'] }}
            </td>
        </tr>
        </tbody>
    </table>

    <table class="w-full text-sm mb-6">
        <thead class="text-xs uppercase">
        <tr class="border-b border-slate-300">
            <td class="py-3 font-semibold">
                Category
            </td>
            <td class="py-3 font-semibold">
                Detail
            </td>
            <td class="py-3 font-semibold">
                Amount
            </td>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice['activities'] as $activity)
            <tr class="border-b border-slate-300">
                <td class="py-3 text-base font-semibold">
                    {{ $activity['category'] }}
                </td>
                <td class="py-3">
                    {{ ($activity['from'] == 'clover' ? '#' : '').$activity['detail'] }}
                </td>
                <td class="py-3">
                    ${{ number_format($activity['price'], 2) }}
                </td>
            </tr>
        @endforeach
        <tr class="border-b border-slate-300">
            <td class="py-3 text-base font-semibold">
                Membership Dues
            </td>
            <td class="py-3">
                {{ $invoice['plan_name'] }}
            </td>
            <td class="py-3">
                ${{ number_format($invoice['plan_price'], 2) }}
            </td>
        </tr>
        <tr class="border-b border-slate-300">
            <td class="py-3 text-base font-semibold">
                TOTAL
            </td>
            <td class="py-3"></td>
            <td class="py-3">
                ${{ number_format($invoice['amount'], 2) }}
            </td>
        </tr>
        </tbody>
    </table>

    @if ($invoice['paid'])
        <p class="text-center">
            Paid on {{ date('n/j/y @ h:i A', strtotime($invoice['paid_at'])) }}
            using {{ strtoupper($invoice['card_type']) }} ending in ****{{ $invoice['card_last4'] }}
        </p>
    @else
        <p class="flex items-center justify-center">
            <b class="mr-1">Unpaid Reason:</b>
            {{ $invoice['reason'] ?? 'Unknown' }}
        </p>
    @endif
</body>
</html>
