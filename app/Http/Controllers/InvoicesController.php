<?php

namespace App\Http\Controllers;

use App\Helpers\Clover;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function index() {
        $invoices = Invoice::query()
            ->with([
                'member' => function ($query) {
                    $query->select(['id', 'memberID', 'firstname', 'lastname', 'avatar', 'card_last4']);
                }
            ])
            ->has('member')
            ->orderByDesc('paid_at')
            ->latest()
            ->get(['id', 'invoiceID', 'member_id', 'period', 'amount', 'paid']);
        return view('invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show($id) {
        $invoice = Invoice::query()
            ->with([
                'member', 'activities', 'activities.member:id,firstname,lastname',
                'plans', 'plans.member:id,firstname,lastname'
            ])
            ->has('member')
            ->find($id);
        if (!$invoice) return back();
        return view('invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    public function download($id) {
        $invoice = Invoice::query()
            ->with([
                'member', 'activities', 'activities.member:id,firstname,lastname',
                'plans', 'plans.member:id,firstname,lastname'
            ])
            ->has('member')
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
        $member = $invoice['member'];
        $clover = new Clover();
        $charge = $clover->getCharge($invoice['invoiceID']);
        $reason = 'The member does not have a Card.';
        if (empty($charge['paid']) && $member['card_last4']) {
            $charge = $clover->createCharge([
                'amount' => $invoice['amount'],
                'source' => $member['customerID'],
                'description' => "PPBRVA {$invoice['period']} invoice for {$member['name']}",
            ]);
            $reason = empty($charge['id']) ? $charge : '3DSecure transactions';
        }
        if (!empty($charge['paid'])) {
            $invoice['invoiceID'] = $charge['id'];
            $invoice['paid'] = true;
            $invoice['card_type'] = $card_type = strtolower($charge['source']['brand']);
            $invoice['card_last4'] = $card_last4 = strtolower($charge['source']['last4']);
            $invoice['paid_at'] = gmdate('Y-m-d H:i:s', $charge['created'] / 1000);
            $invoice['reason'] = null;
            $invoice->save();
            if ($member['card_type'] != $card_type || $member['card_last4'] != $card_last4) {
                $member->update([
                    'card_type' => $card_type,
                    'card_last4' => $card_last4,
                ]);
            }
            return back()->with('success_message', 'Invoice has been created successfully.');
        }
        $invoice['reason'] = $reason;
        $invoice->save();
        return back()->with('error_message', $invoice['reason']);
    }
}
