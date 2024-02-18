<?php

namespace App\Console\Commands;

use App\Helpers\Clover;
use App\Models\Activity;
use App\Models\ActivityItem;
use App\Models\Member;
use Illuminate\Console\Command;

class GetOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get orders from clover.';

    protected const TenderLabels = ['Check'];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clover = new Clover();
        $tenderIds = [];
        $tenders = $clover->getTenders();
        foreach ($tenders as $tender) {
            if (in_array($tender['label'] ?? '', self::TenderLabels)) {
                $tenderIds[] = $tender['id'];
            }
        }
        if (empty($tenderIds)) {
            logger("Cannot find Tender ID!");
            return;
        }
        $members = [];
        $orders = $clover->getOrders();
        foreach ($orders as $order) {
            if (!in_array($order['payments']['elements'][0]['tender']['id'] ?? '', $tenderIds)
                || !($customerID = $order['customers']['elements'][0]['id'] ?? '')
            ) continue;
            $members[$customerID] = $members[$customerID]
                ?? Member::withTrashed()->where('customerID', $customerID)->first(['id'])
                ?? 'Not Found';
            if (!($member_id = $members[$customerID]['id'] ?? null)) continue;
            $price = $order['payments']['elements'][0]['amount'] ?? 0;
            $activity = Activity::query()->updateOrCreate([
                'detail' => $order['id'],
            ], [
                'member_id' => $member_id,
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
