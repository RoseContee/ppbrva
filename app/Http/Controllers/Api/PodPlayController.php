<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\General;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PodPlayController extends Controller
{

    public function podplaysync() {
        $members = DB::table('members')->whereNull('podplay_id')->get();
        $token = env('PODPLAY_LIVE');

        $users = Http::withToken($token)->withHeaders(['Content-Type' => 'application/json'])->get('https://ppbrva.podplay.app/apis/v2/users', ['ipp' => 1000]);    

        foreach ($users["items"] as $u) {
            foreach ($members as $m) {
                if ($u["email"] == strtolower(trim($m->email))) 
                {    
                    $m->podplay_id = $u["id"];
                    print "UPDATE members SET podplay_id='$m->podplay_id' WHERE id='$m->id';<br />";
                }
            }
        }        
    }
    
    public function podplayplans() {
        
        $members = DB::table('members')->where('card_last4', '!=', '')->orWhereNotNull('card_last4')->get();
        return count($members);

        $plans = Plan::all();
        $token = env('PODPLAY_LIVE');

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


            $plan = Http::withToken($token)->withHeaders(['Content-Type' => 'application/json'])->post('https://ppbrva.podplay.app/apis/v2/users/'.$m->podplay_id.'/memberships', [
                'membership' => ['id' => $m->podplay],
                'chargeType' => 'FREE',
                'price' => 0, 
                'initiationFee' => 0   
            ]);

            print $plan.'<br /><br />';
        
        }


    }

    public function podplaycreate() {

        // Get all members without a PodPlay ID
        $members = DB::table('members')->whereNull('podplay_id')->limit(50)->get();

        // Get all memebrs that exist in PodPlay
        $token = env('PODPLAY_LIVE');

        // Create account if it does not exist already
        foreach ($members as $m) {
            $create = Http::withToken($token)->withHeaders(['Content-Type' => 'application/json'])->post('https://ppbrva.podplay.app/apis/v2/users', [
                'firstName' => $m->firstname,
                'lastName' => $m->lastname,
                "email" => $m->email         
            ]);         

            print $create.'<br /><br />';
        }

        // $token = Http::withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])->post('https://ppbrva.podplay.app/apis/v2/oauth2/token', ['username' => 'jim@divstrong.com', 'password' => 'andreab1', 'grant_type', 'password']);    

        // return $token;


        // $users = Http::withToken($token)->withHeaders(['Content-Type' => 'application/json'])->get('https://ppbrva.podplay.app/apis/v2/users', ['ipp' => 10000]);    

        // // Save PodPlay ID locally
        // foreach ($members as $m) {
        //     foreach ($users["items"] as $u) {
        //         if ($u["email"] == strtolower(trim($m->email))) {                
        //             $m->podplay_id = $u["id"];            
        //             print $m->email.' - '.$m->podplay_id. '<br />';
        //         }
        //     }
        // }
    }


    public function podplay() {
        // $members = Member::all();
        // $members = DB::table('members')->skip(0)->limit(25)->get();
        $members = DB::table('members')->where('card_last4', '!=', '')->orWhereNotNull('card_last4')->skip(100)->limit(100)->get();
        // $members = DB::table('members')->whereNull('podplay_id')->skip(0)->limit(25)->get();
        $plans = Plan::all();
        $token = env('PODPLAY_LIVE');

        // $users = Http::withToken($token)->withHeaders(['Content-Type' => 'application/json'])->get('https://ppbrva.podplay.app/apis/v2/users', ['ipp' => 1000]);    

        foreach ($users["items"] as $u) {
            foreach ($members as $m) {
                if ($u["email"] == strtolower(trim($m->email))) {                
                    $m->podplay_id = $u["id"];            
                    $m->save();
                    print $m->email.' - '.$m->podplay_id. '<br />';
                }
            }
        }

        // return $members;
             
        
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


            $plan = Http::withToken($token)->withHeaders(['Content-Type' => 'application/json'])->post('https://ppbrva.podplay.app/apis/v2/users/'.$m->podplay_id.'/memberships', [
                'membership' => ['id' => $m->podplay],
                'chargeType' => 'FREE',
                'price' => 0, 
                'initiationFee' => 0   
            ]);

            print $plan.'<br /><br />';




            // // Check if member exists in Podplay already
            // foreach ($users["items"] as $u) {
            //     print $m->email. ' | '.$u["email"].'<br />';
            //     if ($u["email"] == $m->email) {                
            //         $m->podplayid = $u["id"];            
            //     }
            // }

            // Create account if it does not exist already
            // if ($m->podplayid == 0) {
                // $create = Http::withToken($token)->withHeaders(['Content-Type' => 'application/json'])->post('https://ppbrva.podplay.app/apis/v2/users', [
                //     'firstName' => $m->firstname,
                //     'lastName' => $m->lastname,
                //     "email" => $m->email         
                // ]);         

                // print $create.'<br /><br />';
            // }            
        }

    }

}
