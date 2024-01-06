<?php

namespace App\Console\Commands;

use App\Helpers\Clover;
use App\Models\Activity;
use App\Models\ActivityItem;
use App\Models\Member;
use App\Models\Setting;
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

    protected const TenderKey = 'com.clover.tender.check';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastTime = 0;
        $members = [];
        $clover = new Clover();
        $orders = $clover->getOrders();
        foreach (($orders['elements'] ?? []) as $order) {
            $createdTime = $order['createdTime'] ?? 0;
            if ($createdTime > $lastTime) $lastTime = $createdTime;
            $orderTender = $order['payments']['elements'][0]['tender']['labelKey'] ?? '';
            if (strtolower($orderTender) != self::TenderKey
                || strtoupper($order['paymentState'] ?? '') != 'PAID'
                || !($price = $order['total'] ?? 0)
                || !($customerID = $order['customers']['elements'][0]['id'] ?? '')
            ) continue;
            if (empty($members[$customerID])) {
                $members[$customerID] = Member::withTrashed()
                    ->with(['location'])
                    ->where('customerID', $customerID)
                    ->first(['id', 'location_id']);
            }
            if (!($member = $members[$customerID] ?? null)) continue;
            $activity = Activity::query()->updateOrCreate([
                'detail' => $order['id'] ?? $order['title'] ?? 'Clover Order',
            ], [
                'member_id' => $member['id'],
                'category' => ($member['location']['name'] ?? 'Unknown').' POS',
                'price' => $price / 100,
                'date' => gmdate('Y-m-d', $createdTime / 1000),
                'from' => 'clover',
            ]);
            if ($activity['invoice_id']) {
                $clover->updateOrderTotal($order['id']);
            }
            foreach (($order['lineItems']['elements'] ?? []) as $item) {
                ActivityItem::query()->updateOrCreate([
                    'activity_id' => $activity['id'],
                ], [
                    'name' => $item['name'] ?? 'Order Item',
                    'price' => ($item['price'] ?? 0) / 100,
                ]);
            }
        }
        if ($lastTime) Setting::saveSetting('last_order_updated', $lastTime);
    }
}
