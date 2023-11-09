<?php

namespace App\Console\Commands;

use App\Helpers\Clover;
use App\Models\Activity;
use App\Models\ActivityItem;
use App\Models\Member;
use Illuminate\Console\Command;

class GetCloverOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-clover-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get orders from clover.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clover = new Clover();
        $orders = $clover->getOrders();
        $members = [];
        foreach (($orders['elements'] ?? []) as $order) {
            if ($order['paymentState'] !== 'PAID'
                || ($order['payments']['elements'][0]['tender']['labelKey'] ?? '') !== 'com.clover.tender.check'
            ) continue;
            $customerId = $order['customers']['elements'][0]['id'] ?? '';
            if (!isset($members[$customerId])) {
                $members[$customerId] = Member::withTrashed()
                    ->with(['location'])
                    ->where('customer_id', $customerId)
                    ->first();
            }
            $member = $members[$customerId] ?? null;
            Activity::updateOrCreate([
                'detail' => $order['id'],
            ], [
                'member_id' => $member['id'] ?? '',
                'category' => ($member['location']['name'] ?? '').' POS',
                'price' => $order['total'] / 100,
                'date' => gmdate('Y-m-d', $order['createdTime'] / 1000),
                'from' => 'clover',
            ]);
            $lineItems = $order['lineItems']['elements'] ?? [];
            foreach ($lineItems as $item) {
                ActivityItem::updateOrCreate([
                    'order_id' => $order['id'],
                ], [
                    'name' => $item['name'],
                    'price' => $item['price'] / 100,
                ]);
            }
        }
    }
}
