<?php

namespace App\Console\Commands;

use App\Helpers\Clover;
use App\Models\Invoice;
use App\Models\InvoicePlan;
use App\Models\Member;
use App\Models\Plan;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        $today = date('Y-m-d');
        $clover = new Clover();
        $members = Member::query()
            ->with([
                'plan:id,name,price',
                'activities' => function (HasMany $query) use ($today) {
                    $query->where('date', '<', $today)
                        ->whereNull('invoice_id')
                        ->select(['member_id', 'detail', 'price']);
                },
                'families:id,primary_id,secondary_fee,status,pause_from,pause_to',
                'families.activities' => function (HasMany $query) use ($today) {
                    $query->where('date', '<', $today)
                        ->whereNull('invoice_id')
                        ->select(['member_id', 'detail', 'price']);
                },
            ])
            ->where(function (Builder $query) use ($today) {
                $query->whereIn('status', ['active', 'suspended'])
                    ->orWhere(function (Builder $query) use ($today) {
                        $query->where('status', 'paused')
                            ->where(function (Builder $query) use ($today) {
                                $query->where('pause_from', '>', $today)
                                    ->orWhere('pause_to', '<', $today);
                            });
                    });
            })
            ->where(function (Builder $query) {
                $query->where('plan_id', '<>', Plan::FamilyPlanId)
                    ->orWhereNull('primary_id');
            })
            ->get([
                'id', 'firstname', 'lastname', 'plan_id',
                'customerID', 'card_last4', 'card_type',
            ]);
        foreach ($members as $member) {
            $plan_name = $member['plan']['name'] ?? 'Unknown';
            $amount = $plan_price = $member['plan']['price'] ?? 0;
            $activities = $member['activities'];
            foreach ($activities as $activity) {
                $amount += $activity['price'];
            }
            $families = $member['families'];
            foreach ($families as $family) {
                if (in_array($family['status'], ['active', 'suspended'])
                    || ($family['status'] == 'paused'
                        && ($family['pause_from'] > $today || $family['pause_to'] < $today)
                    )
                ) {
                    $amount += $family['secondary_fee'] ?? 0;
                }
                foreach ($family['activities'] as $activity) {
                    $amount += $activity['price'];
                }
            }
            $charge = $clover->createCharge([
                'amount' => $amount,
                'source' => $member['customerID'],
                'description' => "PPBRVA {$period} invoice for ".$member['name'],
            ]);
            $paid = !empty($charge['paid']);
            $card_type = strtolower($charge['source']['brand'] ?? $member['card_type']);
            $card_last4 = strtolower($charge['source']['last4'] ?? $member['card_last4']);
            $invoice = Invoice::query()->create([
                'invoiceID' => $charge['id'] ?? ('PPB-'.Str::random()),
                'member_id' => $member['id'],
                'period' => $period,
                'amount' => $amount,
                'paid' => $paid,
                'card_type' => $card_type,
                'card_last4' => $card_last4,
                'paid_at' => $paid ? gmdate('Y-m-d H:i:s', $charge['created'] / 1000) : null,
                'reason' => $paid ? null : (empty($charge['id']) ? $charge : '3DSecure transactions'),
            ]);
            if ($member['card_type'] != $card_type || $member['card_last4'] != $card_last4) {
                $member->update([
                    'card_type' => $card_type,
                    'card_last4' => $card_last4,
                ]);
            }
            InvoicePlan::query()->create([
                'invoice_id' => $invoice['id'],
                'member_id' => $member['id'],
                'name' => $plan_name,
                'price' => $plan_price,
            ]);
            $member->activities()->update([
                'invoice_id' => $invoice['id'],
            ]);
            foreach ($activities as $activity) {
                $clover->updateOrderTotal($activity['detail']);
            }
            foreach ($families as $family) {
                if (in_array($family['status'], ['active', 'suspended'])
                    || ($family['status'] == 'paused'
                        && ($family['pause_from'] > $today || $family['pause_to'] < $today)
                    )
                ) {
                    InvoicePlan::query()->create([
                        'invoice_id' => $invoice['id'],
                        'member_id' => $family['id'],
                        'name' => $plan_name,
                        'price' => $family['secondary_fee'] ?? 0,
                    ]);
                }
                $family->activities()->update([
                    'invoice_id' => $invoice['id'],
                ]);
                foreach ($family['activities'] as $activity) {
                    $clover->updateOrderTotal($activity['detail']);
                }
            }
        }
    }
}
