<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function invoices(Request $request) {
        $invoices = $request->user()
            ->invoices()
            ->where('paid', true)
            ->orderByDesc('paid_at')
            ->latest()
            ->get(['invoiceID', 'period', 'amount']);
        return response()->json([
            'invoices' => $invoices
        ]);
    }

    public function invoiceDetail(Request $request, $invoiceID) {
        $invoice = $request->user()
            ->invoices()
            ->with(['activities:invoiceID,category,detail,price'])
            ->where('invoiceID', $invoiceID)
            ->where('paid', true)
            ->first(['invoiceID', 'amount', 'period', 'plan_name', 'plan_price']);
        if (!$invoice) {
            return response()->json([
                'message' => 'Not found invoice.',
            ], 404);
        }
        $period = new Carbon($invoice['period']);
        $invoice['from'] = $period->firstOfMonth()->format('n/j/y');
        $invoice['to'] = $period->lastOfMonth()->format('n/j/y');
        return response()->json([
            'invoice' => $invoice,
        ]);
    }

    public function invoiceDownload(Request $request, $invoiceID) {
        $invoice = $request->user()
            ->invoices()
            ->with(['member', 'activities'])
            ->where('invoiceID', $invoiceID)
            ->where('paid', true)
            ->first();
        if (!$invoice) {
            return response()->json(null, 404);
        }
        return Pdf::loadView('invoices.download', [
            'invoice' => $invoice
        ])->download("{$invoice['invoiceID']}.pdf");
    }

    public function activities() {
        $activities = Activity::query()
            ->with(['items:orderID,name,price'])
            ->where('member_id', auth()->id())
            ->orderByDesc('date')
            ->orderBy('category')
            ->orderBy('detail')
            ->get(['category', 'detail', 'price', 'date']);
        return response()->json([
            'activities' => $activities,
        ]);
    }
}
