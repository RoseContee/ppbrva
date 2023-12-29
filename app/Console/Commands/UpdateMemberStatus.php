<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;

class UpdateMemberStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-member-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update members status to active if pause end date has passed.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Member::query()
            ->where('status', 'paused')
            ->where('pause_to', '<', date('Y-m-d'))
            ->update([
                'status' => 'active',
                'pause_from' => null,
                'pause_to' => null,
            ]);
    }
}
