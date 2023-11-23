<?php

namespace App\Console\Commands;

use App\Helpers\Clover;
use App\Models\KitchenBar;
use Illuminate\Console\Command;

class GetKitchenBarItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-kitchen-bar-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get inventory items from clover.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clover = new Clover();
        $inventoryItems = $clover->getInventoryItems();
        foreach ($inventoryItems as $item) {
            KitchenBar::updateOrCreate([
                'itemID' => $item['itemID'],
            ], [
                'item' => $item['item'],
                'price' => $item['price'] / 100,
                'category' => $item['category'],
                'sortOrder' => $item['sortOrder'],
            ]);
        }
        KitchenBar::whereNotIn('itemID', array_keys($inventoryItems))->delete();
    }
}
