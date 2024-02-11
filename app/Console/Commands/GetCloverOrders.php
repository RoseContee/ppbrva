<?php

namespace App\Console\Commands;

use App\Helpers\Clover;
use App\Models\Activity;
use App\Models\ActivityItem;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

    protected const TenderLabel = 'Check';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clover = new Clover();
        $tenderId = null;
        $tenders = $clover->getTenders();
        foreach ($tenders as $tender) {
            if (!strcasecmp($tender['label'] ?? '', self::TenderLabel)) {
                $tenderId = $tender['id'] ?? null;
                break;
            }
        }
        if (!$tenderId) {
            logger("Cannot find Tender ID!");
            return;
        }
        $now = now();
        $members = [];
        $fetchedOrders = DB::table('activity_fetched')
            ->pluck('orderID')
            ->toArray();
        $customerIds = Member::withTrashed()
            ->pluck('customerID')
            ->toArray();
        $orderIds = $clover->getOrderIds($customerIds);
        foreach ($orderIds as $orderId) {
            if (in_array($orderId, $fetchedOrders)) continue;
            $order = $clover->getOrder($orderId);
            if (empty($order['id'])) continue;
            DB::table('activity_fetched')->insert([
                'orderID' => $order['id'],
                'created_at' => $now,
            ]);
            if (($order['payments']['elements'][0]['tender']['id'] ?? '') != $tenderId
                || !($customerID = $order['customers']['elements'][0]['id'] ?? '')
            ) continue;
            if (empty($members[$customerID])) {
                $members[$customerID] = Member::withTrashed()
                    ->where('customerID', $customerID)
                    ->first(['id']);
            }
            if (!($member = $members[$customerID] ?? null)) continue;
            $price = $order['payments']['elements'][0]['amount'] ?? 0;
            $activity = Activity::query()->updateOrCreate([
                'detail' => $order['id'],
            ], [
                'member_id' => $member['id'],
                'category' => 'Food/Beverage/Merch',
                'price' => $price / 100,
                'date' => gmdate('Y-m-d', $order['createdTime'] / 1000),
                'from' => 'clover',
            ]);
            foreach (($order['lineItems']['elements'] ?? []) as $i => $item) {
                ActivityItem::query()->updateOrCreate([
                    'activity_id' => $activity['id'],
                    'itemID' => $item['id'] ?? "Unknown-{$i}",
                ], [
                    'name' => $item['name'] ?? 'Order Item',
                    'price' => ($item['price'] ?? 0) / 100,
                ]);
            }
        }
    }
}
