<?php

namespace App\Console\Commands;

use App\Helpers\Dupr;
use App\Models\MemberProfile;
use Illuminate\Console\Command;

class GetDupr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-dupr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get DUPR info';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dupr = new Dupr();
        $members = MemberProfile::query()
            ->whereNotNull('dupr_id')
            ->get();
        foreach ($members as $member) {
            $duprInfo = $dupr->getPlayInfo($member['dupr_id']);
            $member['gender'] = $duprInfo['gender'];
            $member['age'] = $duprInfo['age'];
            $member['rating'] = $duprInfo['rating'];
            $member['matches'] = $duprInfo['matches'];
            $member['wins'] = $duprInfo['wins'];
            $member['losses'] = $duprInfo['losses'];
            $member->save();
        }
    }
}
