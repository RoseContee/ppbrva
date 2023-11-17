<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateCloverOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-clover-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update failed orders status again';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
