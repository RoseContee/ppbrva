<?php

namespace App\Http\Controllers;

use App\Helpers\Clover;
use App\Models\Activity;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function index() {
        $invoices = Invoice::query()
            ->with([
                'member' => function ($query) {
                    $query->select(['id', 'memberID', 'firstname', 'lastname', 'avatar']);
                }
            ])
            ->orderByDesc('paid_at')
            ->latest()
            ->get(['id', 'invoiceID', 'member_id', 'period', 'amount', 'paid']);
        return view('invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show($id) {
        $invoice = Invoice::query()
            ->with(['member', 'activities'])
            ->find($id);
        if (!$invoice) return back();
        return view('invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    public function download($id) {
        $invoice = Invoice::query()
            ->with(['member', 'activities'])
            ->find($id);
        if (!$invoice) return back();
        /*return view('invoices.download', [
            'invoice' => $invoice,
        ]);*/
        return Pdf::loadView('invoices.download', [
            'invoice' => $invoice
        ])->download("{$invoice['invoiceID']}.pdf");
    }

    public function pay($id) {
        $invoice = Invoice::query()
            ->with(['member'])
            ->has('member')
            ->where('paid', false)
            ->find($id);
        if (!$invoice) return back();
        $clover = new Clover();
        $charge = $clover->getCharge($invoice['invoiceID']);
        if (empty($charge['paid'])) {
            $charge = $clover->createCharge([
                'amount' => $invoice['amount'],
                'source' => $invoice['member']['customerID'],
                'description' => 'PPBRVA invoice for '.$invoice['period'],
            ]);
        }
        if (!empty($charge['paid'])) {
            Activity::query()
                ->where('invoiceID', $invoice['invoiceID'])
                ->update([
                    'invoiceID' => $charge['id'],
                ]);
            $invoice['invoiceID'] = $charge['id'];
            $invoice['paid'] = true;
            $invoice['card_type'] = $charge['source']['brand'] ?? $invoice['member']['card_type'];
            $invoice['card_last4'] = $charge['source']['last4'] ?? $invoice['member']['card_last4'];
            $invoice['paid_at'] = gmdate('Y-m-d H:i:s', $charge['created'] / 1000);
            $invoice['reason'] = null;
            $invoice->save();
            return back()->with('success_message', 'Invoice has been created successfully.');
        }
        $invoice['reason'] = empty($charge['id']) ? $charge : '3DSecure transactions';
        $invoice->save();
        return back()->with('error_message', $invoice['reason']);
    }
}
