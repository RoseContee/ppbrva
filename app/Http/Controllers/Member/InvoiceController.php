<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index() {
        $user = auth('member')->user();
        $invoices = Invoice::query()
            ->where('member_id', $user['id'])
            ->orderByDesc('paid_at')
            ->latest()
            ->get(['id', 'invoiceID', 'period', 'amount', 'paid']);
        return view('member.invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show($id) {
        $user = auth('member')->user();
        $invoice = Invoice::query()
            ->with([
                'activities', 'activities.member:id,firstname,lastname',
                'plans', 'plans.member:id,firstname,lastname'
            ])
            ->where('member_id', $user['id'])
            ->find($id);
        if (!$invoice) return back();
        return view('member.invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    public function download($id) {
        $user = auth('member')->user();
        $invoice = Invoice::query()
            ->with([
                'member', 'activities', 'activities.member:id,firstname,lastname',
                'plans', 'plans.member:id,firstname,lastname'
            ])
            ->where('member_id', $user['id'])
            ->find($id);
        if (!$invoice) return back();
        /*return view('invoices.download', [
            'invoice' => $invoice,
        ]);*/
        return Pdf::loadView('invoices.download', [
            'invoice' => $invoice
        ])->download("{$invoice['invoiceID']}.pdf");
    }
}
