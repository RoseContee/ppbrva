<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Member;
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
            ->with([
                'member:id,firstname,lastname',
                'activities:member_id,invoice_id,category,detail,price',
                'activities.member:id,firstname,lastname',
                'plans:invoice_id,member_id,name,price',
                'plans.member:id,firstname,lastname'
            ])
            ->where('invoiceID', $invoiceID)
            ->where('paid', true)
            ->first(['id', 'member_id', 'invoiceID', 'amount', 'period']);
        if (!$invoice) {
            return response()->json(['message' => 'Not found invoice.'], 404);
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
            ->with([
                'member', 'activities', 'activities.member', 'plans', 'plans.member'
            ])
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
        $user_id = auth()->id();
        $members = Member::query()
            ->where('id', $user_id)
            ->orWhere('primary_id', $user_id)
            ->pluck('id')
            ->toArray();
        $activities = Activity::query()
            ->with([
                'member:id,firstname,lastname,avatar',
                'items:activity_id,name,price',
            ])
            ->whereIn('member_id', $members)
            ->orderByDesc('date')
            ->orderBy('category')
            ->orderBy('detail')
            ->get(['id', 'member_id', 'category', 'detail', 'price', 'date']);
        return response()->json([
            'activities' => $activities,
        ]);
    }
}
