<?php

namespace App\Console\Commands;

use App\Helpers\Clover;
use App\Models\Invoice;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class CreateInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create invoices from clover every month.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $period = date('F Y', strtotime('-1 days'));
        $clover = new Clover();
        $members = Member::query()
            ->with([
                'plan',
                'activities' => function ($q) {
                    $q->where('date', '<', date('Y-m-d'))
                        ->whereNull('invoiceID');
                }
            ])
            ->where('status', 'active')
            ->orWhere(function (Builder $query) {
                $query->where('status', 'paused')
                    ->where(function (Builder $query) {
                        $today = date('Y-m-d');
                        $query->where('pause_from', '>', $today)
                            ->orWhere('pause_to', '<', $today);
                    });
            })
            ->get();
        foreach ($members as $member) {
            $activities = $member['activities'];
            $amount = $plan_price = $member['plan']['price'] ?? 0;
            foreach ($activities as $activity) {
                $amount += $activity['price'];
            }
            $charge = $clover->createCharge([
                'amount' => $amount,
                'source' => $member['customerID'],
                'description' => 'PPBRVA invoice for '.$period,
            ]);
            $invoiceID = $charge['id'] ?? ('PPB-'.Str::random());
            $paid = !empty($charge['paid']);
            Invoice::create([
                'invoiceID' => $invoiceID,
                'member_id' => $member['id'],
                'period' => $period,
                'amount' => $amount,
                'paid' => $paid,
                'plan_name' => $member['plan']['name'],
                'plan_price' => $plan_price,
                'card_type' => $charge['source']['brand'] ?? $member['card_type'],
                'card_last4' => $charge['source']['last4'] ?? $member['card_last4'],
                'paid_at' => $paid ? gmdate('Y-m-d H:i:s', $charge['created'] / 1000) : null,
                'reason' => $paid ? null : (empty($charge['id']) ? $charge : '3DSecure transactions'),
            ]);
            foreach ($activities as $activity) {
                $activity['invoiceID'] = $invoiceID;
                $clover->updateOrderStatus($activity['detail']);
                $activity->save();
            }
        }
    }
}
