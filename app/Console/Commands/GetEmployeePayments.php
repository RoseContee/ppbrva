<?php

namespace App\Console\Commands;

use App\Helpers\Clover;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetEmployeePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-employee-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get employee payments from clover.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clover = new Clover();
        $payments = $clover->getPayments();
        foreach ($payments as $payment) {
            DB::table('employee_payments')->updateOrInsert([
                'paymentID' => $payment['id'],
            ], [
                'price' => ($payment['amount'] ?? 0) / 100,
                'note' => $payment['note'],
                'created_at' => gmdate('Y-m-d H:i:s', $payment['createdTime'] / 1000),
            ]);
        }
    }
}
