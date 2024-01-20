<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PodPlayController extends Controller
{
    public function podplaytoken() {
        try {
            $username = env('PODPLAY_USER');
            $password = env('PODPLAY_PASS');
            $grant = 'password';
            $request = Http::withHeaders([
                'accept' => 'application/json','Content-Type' => 'application/x-www-form-urlencoded'
            ])
                ->asForm()
                ->post("https://ppbrva.podplay.app/apis/v2/oauth2/token", [
                    'username' => $username,
                    'password' => $password,
                    'grant_type' => $grant
                ]);
        } catch (\Exception $exception) {
            logger('PodPlay Token Error');
            logger($exception->getMessage());
        }
        return $request['access_token'] ?? null;
    }

    public function podplaynew(Request $request) {
        try {
            $token = $this->podplaytoken();
            $create = Http::withToken($token)->withHeaders([
                'Content-Type' => 'application/json'
            ])
                ->post("https://ppbrva.podplay.app/apis/v2/users", [
                    'firstName' => $request['firstname'],
                    'lastName' => $request['lastname'],
                    "email" => $request['email']
                ]);
        } catch (\Exception $exception) {
            logger('PodPlay New Error');
            logger($exception->getMessage());
        }
        return $create['id'] ?? null;
    }

    public function podplaynewplan($member) {
        try {
            // Find member and map local plan ID to podplay plan ID
            if ($member['plan_id'] == 1) $podplay = 'elite-team';
            else if ($member['plan_id'] == 2) $podplay = 'performance-team';
            else if ($member['plan_id'] == 3) $podplay = 'corporate';
            else if ($member['plan_id'] == 4) $podplay = 'morning-team';
            else if ($member['plan_id'] == 5) $podplay = 'student-team';
            else if ($member['plan_id'] == 8) $podplay = 'family-elite';
            else if ($member['plan_id'] == 12) $podplay = 'family-elite-complementary';
            else if ($member['plan_id'] == 11) $podplay = 'elite-team';
            else $podplay = NULL;

            $token = $this->podplaytoken();
            $plan = Http::withToken($token)->withHeaders([
                'Content-Type' => 'application/json'
            ])
                ->post("https://ppbrva.podplay.app/apis/v2/users/{$member['podplay_id']}/memberships", [
                    'membership' => [
                        'id' => $podplay
                    ],
                    'chargeType' => 'FREE',
                    'price' => 0,
                    'initiationFee' => 0
                ]);
        } catch (\Exception $exception) {
            logger('PodPlay New Plan Error');
            logger($exception->getMessage());
        }
        return $plan ?? null;
    }

    public function podplaysync() {
        $token = $this->podplaytoken();
        $members = DB::table('members')->whereNull('podplay_id')->get();
        $users = Http::withToken($token)->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->get("https://ppbrva.podplay.app/apis/v2/users", [
                'ipp' => 1000
            ]);

        foreach ($users["items"] as $u) {
            foreach ($members as $m) {
                if ($u["email"] == strtolower(trim($m->email))) {
                    $m->podplay_id = $u["id"];
                    print "UPDATE members SET podplay_id='$m->podplay_id' WHERE id='$m->id';<br />";
                }
            }
        }
    }

    public function podplayplans() {
        $members = DB::table('members')
            ->where('card_last4', '!=', '')
            ->orWhereNotNull('card_last4')
            ->get();
        return count($members);

        $plans = Plan::all();
        $token = $this->podplaytoken();

        // Logic
        foreach ($members as $m) {
            // Map local plans to Podplay plans
            if ($m->plan_id == 1) $podplay = 'elite-team';
            else if ($m->plan_id == 2) $podplay = 'performance-team';
            else if ($m->plan_id == 3) $podplay = 'corporate';
            else if ($m->plan_id == 4) $podplay = 'morning-team';
            else if ($m->plan_id == 5) $podplay = 'student-team';
            else if ($m->plan_id == 8) $podplay = 'family-elite';
            else if ($m->plan_id == 12) $podplay = 'family-elite-complementary';
            else if ($m->plan_id == 11) $podplay = 'elite-team';
            $m->podplay = $podplay;

            $plan = Http::withToken($token)->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->post("https://ppbrva.podplay.app/apis/v2/users/{$m->podplay_id}/memberships", [
                    'membership' => [
                        'id' => $m->podplay
                    ],
                    'chargeType' => 'FREE',
                    'price' => 0,
                    'initiationFee' => 0
                ]);
            print $plan.'<br /><br />';
        }
    }

    public function podplaycreate() {
        // Get all members without a PodPlay ID
        $members = DB::table('members')
            ->whereNull('podplay_id')
            ->limit(50)
            ->get();

        // Get all memebrs that exist in PodPlay
        $token = $this->podplaytoken();

        // Create account if it does not exist already
        foreach ($members as $m) {
            $create = Http::withToken($token)->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->post("https://ppbrva.podplay.app/apis/v2/users", [
                    'firstName' => $m->firstname,
                    'lastName' => $m->lastname,
                    "email" => $m->email
                ]);
            print $create.'<br /><br />';
        }
    }

//    public function podplaytest() {
//        $token = $this->podplaytoken();
//
//        $create = Http::withToken($token)->withHeaders([
//                'Content-Type' => 'application/json'
//            ])
//            ->post('https://ppbrva.podplay.app/apis/v2/users', [
//                'firstName' => 'Test',
//                'lastName' => 'Test',
//                "email" => 'help2@divstrong.com'
//            ]);
//        return $create['id'];
//    }
}
