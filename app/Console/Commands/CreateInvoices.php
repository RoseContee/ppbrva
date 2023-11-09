<?php

namespace App\Console\Commands;

use App\Helpers\Clover;
use App\Models\Member;
use Illuminate\Console\Command;

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
    protected $description = 'Create invoices every month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clover = new Clover();
        $members = Member::with(['activities'])->get();
        foreach ($members as $member) {
        }
    }
}
