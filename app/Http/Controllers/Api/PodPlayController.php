<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PodPlay;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class PodPlayController extends Controller
{
    public function token() {
        $podplay = new PodPlay();
        return $podplay->getToken();
    }

    public function create() {
        // Get all members without a PodPlay ID
        $members = Member::query()
            ->whereNull('podplay_id')
            ->get();

        $podplay = new PodPlay();
        // Create account if it does not exist already
        foreach ($members as $member) {
            $podplay_id = $podplay->createUser([
                'firstName' => $member['firstname'],
                'lastName' => $member['lastname'],
                'email' => $member['email'],
            ]);
            if ($podplay_id) {
                $member->update([
                    'podplay_id' => $podplay_id,
                ]);
            }
        }
    }

    public function plans() {
        $members = Member::query()
            ->where('card_last4', '<>', '')
            ->orWhereNotNull('card_last4')
            ->get();
        return count($members);

        $podplay = new PodPlay();
        // Logic
        foreach ($members as $member) {
            $podplay->createMembership($member);
        }
    }

    public function sync() {
        $members = Member::query()
            ->whereNull('podplay_id')
            ->get();
        $podplay = new PodPlay();
        $users = $podplay->getUsers();
        foreach ($users as $u) {
            foreach ($members as $m) {
                if ($u['email'] == strtolower(trim($m['email']))) {
                    $m['podplay_id'] = $u['id'];
                    print "UPDATE members SET podplay_id='{$m['podplay_id']}' WHERE id='{$m['id']}';<br />";
                }
            }
        }
    }
}
