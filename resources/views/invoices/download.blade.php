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
        .text-primary {
            color: #0e74be;
        }
        .text-title {
            color: #1a2755;
        }
        .text-body {
            color: #444040;
        }
        .text-gray {
            color: #8d8d8e;
        }
        .text-white {
            color: #fff;
        }
        .bg-success {
            background-color: #26b91b;
        }
        .bg-failed {
            background-color: #f30e15;
        }
        .vertical-middle {
            vertical-align: middle;
        }
        .vertical-bottom {
            vertical-align: bottom;
        }
    </style>
</head>
<body class="font-sans antialiased text-body">
    <table class="w-full mb-6">
        <tbody>
        <tr>
            <td class="vertical-middle">
                <h5 class="font-bold text-sm text-primary mb-1">
                    <span class="text-title">Invoice</span> #{{ $invoice['invoiceID'] }}
                </h5>
                <h2 class="font-bold text-xl text-title mb-1">
                    {{ $invoice['period'] }}
                </h2>
                <p class="text-xs text-gray">
                    @php $period = \Carbon\Carbon::parse($invoice['period']); @endphp
                    {{ $period->firstofMonth()->format('n/j/y') }} - {{ $period->endOfMonth()->format('n/j/y') }}
                </p>
            </td>
            <td class="text-center w-44">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="inline-block w-20">
            </td>
        </tr>
        </tbody>
    </table>

    @php $member = $invoice['member']; @endphp
    <table class="w-full text-title text-sm mb-6">
        <tbody>
        <tr>
            <td>
                <p class="font-bold text-primary">{{ $member['name'] }}</p>
                <p>{{ $member['address'] }} {{ $member['city'] }}, {{ $member['state'] }} {{ $member['zipcode'] }}</p>
                <p>{{ $member['phone'] }}</p>
                <p>{{ $member['email'] }}</p>
            </td>
            <td class="vertical-middle text-center w-44">
                @if ($invoice['paid'])
                    <span class="bg-success text-white text-sm px-4 py-1 rounded-lg">
                        PAID
                    </span>
                    <p class="text-xs mt-3">
                        {{ date('n/j/y @ H:iA', strtotime($invoice['paid_at'])) }}
                    </p>
                    <p class="text-xs">
                        {{ strtoupper($invoice['card_type']) }}
                    </p>
                @else
                    <span class="bg-failed text-white text-sm px-4 py-1 rounded-lg">
                        UNPAID
                    </span>
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    <table class="w-full text-sm mb-6">
        <thead class="font-sans text-xs uppercase">
        <tr class="border-b border-slate-300">
            <td class="py-3 font-bold">
                Category
            </td>
            <td class="py-3 font-bold">
                Detail
            </td>
            <td class="py-3 font-bold">
                Amount
            </td>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice['activities'] as $activity)
            <tr class="border-b border-slate-300">
                <td class="py-3 text-base">
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
            <td class="py-3 text-base">
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
            <td class="py-3 text-base font-bold">
                TOTAL
            </td>
            <td class="py-3"></td>
            <td class="py-3">
                ${{ number_format($invoice['amount'], 2) }}
            </td>
        </tr>
        </tbody>
    </table>

    <div class="text-sm text-gray text-center">
        <p>{{ config('app.name') }}</p>
        <p>{{ env('CONTACT_ADDRESS') }}</p>
        <p class="text-primary underline">
            <a href="https://ppbrva.com/">www.ppbrva.com</a>
        </p>
    </div>
</body>
</html>
