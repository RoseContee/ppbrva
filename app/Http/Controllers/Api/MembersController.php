<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberFriend;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function members() {
        $members = Member::query()
            ->with(['profile:member_id,share_age_gender,age,gender,rating'])
            ->where('id', '<>', auth()->id())
            ->get(['id', 'memberID', 'firstname', 'lastname', 'avatar']);
        return response()->json([
            'members' => $members,
        ]);
    }

    public function friends() {
        $members = []; $pending_requests = 0;
        $user = Member::query()
            ->with([
                'friends1' => function ($query) {
                    $query->with(['profile:member_id,share_age_gender,age,gender,rating'])
                        ->wherePivotIn('status', ['pending', 'accepted'])
                        ->withPivot('status')
                        ->select(['members.id', 'memberID', 'firstname', 'lastname', 'avatar']);
                },
                'friends2' => function ($query) {
                    $query->with(['profile:member_id,share_age_gender,age,gender,rating'])
                        ->wherePivot('status', 'accepted')
                        ->withPivot('status')
                        ->select(['members.id', 'memberID', 'firstname', 'lastname', 'avatar']);
                },
            ])
            ->find(auth()->id(), ['id'])
            ->toArray();
        foreach (array_merge($user['friends1'], $user['friends2']) as $friend) {
            $relation = $friend['relation'];
            if ($relation['status'] === 'accepted') $members[] = $friend;
            else $pending_requests++;
        }
        return response()->json([
            'members' => $members,
            'pending_requests' => $pending_requests,
        ]);
    }

    public function pendingFriends() {
        $user = Member::query()
            ->with([
                'friends1' => function ($query) {
                    $query->with(['profile:member_id,share_age_gender,age,gender,rating'])
                        ->wherePivot('status', 'pending')
                        ->withPivot('status')
                        ->select(['members.id', 'memberID', 'firstname', 'lastname', 'avatar']);
                },
            ])
            ->find(auth()->id(), ['id'])
            ->toArray();
        return response()->json([
            'members' => $user['friends1'],
        ]);
    }

    public function member($memberID) {
        $user_id = auth()->id();
        $member = Member::query()
            ->with([
                'profile:member_id,share_age_gender,age,gender,rating,matches,wins,losses',
                'friends1' => function ($query) use ($user_id) {
                    $query->wherePivot('member1_id', $user_id)
                        ->withPivot(['member1_email', 'member1_phone', 'member2_email', 'member2_phone', 'status'])
                        ->select(['memberID']);
                },
                'friends2' => function ($query) use ($user_id) {
                    $query->wherePivot('member2_id', $user_id)
                        ->withPivot(['member1_email', 'member1_phone', 'member2_email', 'member2_phone', 'status'])
                        ->select(['memberID']);
                },
            ])
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->first(['id', 'memberID', 'firstname', 'lastname', 'email', 'phone', 'avatar']);
        if (!$member) {
            return response()->json([
                'message' => 'Not found member.',
            ], 404);
        }
        $friend1 = $member['friends1'][0]['relation'] ?? null;
        $friend2 = $member['friends2'][0]['relation'] ?? null;
        $status = $friend1['status'] ?? $friend2['status'] ?? '';
        $email_share = !empty($friend1['member2_email'] ?? $friend2['member1_email'] ?? 0);
        $phone_share = !empty($friend1['member2_phone'] ?? $friend2['member1_phone'] ?? 0);
        $my_email_share = !empty($friend1['member1_email'] ?? $friend2['member2_email'] ?? 0);
        $my_phone_share = !empty($friend1['member1_phone'] ?? $friend2['member2_phone'] ?? 0);
        return response()->json([
            'member' => [
                'id' => $member['id'],
                'memberID' => $member['memberID'],
                'name' => $member['name'],
                'email' => $email_share ? $member['email'] : null,
                'phone' => $phone_share ? $member['phone'] : null,
                'avatar' => $member['avatar'],
                'email_share' => $email_share,
                'phone_share' => $phone_share,
                'my_email_share' => $my_email_share,
                'my_phone_share' => $my_phone_share,
                'friend_status' => $status == 'pending' && ($friend1['member1_id'] ?? 0) == $user_id ? 'waiting' : $status,
                'profile' => $member['profile'],
            ],
        ]); //accepted, pending, waiting, null
    }

    public function invite(Request $request, $memberID) {
        $user_id = auth()->id();
        $member = Member::query()
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->first(['id']);
        if (!$member) {
            return response()->json([
                'message' => 'Not found member.',
            ], 404);
        }
        $friend = MemberFriend::query()
            ->where(function ($query) use ($user_id, $member) {
                $query->where('member1_id', $user_id)
                    ->where('member2_id', $member['id']);
            })
            ->orWhere(function ($query) use ($user_id, $member) {
                $query->where('member1_id', $member['id'])
                    ->where('member2_id', $user_id);
            })
            ->firstOrNew();
        if ($friend['status']) {
            return response()->json([
                'message' => 'Cannot request a friend at the moment.'
            ], 403);
        }
        $friend['member1_id'] = $user_id;
        $friend['member1_email'] = !empty($request['email_share']);
        $friend['member1_phone'] = !empty($request['phone_share']);
        $friend['member2_id'] = $member['id'];
        $friend['member2_email'] = false;
        $friend['member2_phone'] = false;
        $friend['status'] = 'pending';
        $friend->save();
        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function accept(Request $request, $memberID) {
        $user_id = auth()->id();
        $member = Member::query()
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->first(['id']);
        if (!$member) {
            return response()->json([
                'message' => 'Not found member.',
            ], 404);
        }
        $friend = MemberFriend::query()
            ->where('member1_id', $member['id'])
            ->where('member2_id', $user_id)
            ->where('status', 'pending')
            ->first();
        if (!$friend) {
            return response()->json([
                'message' => 'Not found request.'
            ], 404);
        }
        $friend['member2_email'] = !empty($request['email_share']);
        $friend['member2_phone'] = !empty($request['phone_share']);
        $friend['status'] = 'accepted';
        $friend->save();
        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function decline(Request $request, $memberID) {
        $user_id = auth()->id();
        $member = Member::query()
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->first(['id']);
        if (!$member) {
            return response()->json([
                'message' => 'Not found member.',
            ], 404);
        }
        $friend = MemberFriend::query()
            ->where('member1_id', $member['id'])
            ->where('member2_id', $user_id)
            ->where('status', 'pending')
            ->first();
        if (!$friend) {
            return response()->json([
                'message' => 'Not found request.'
            ], 404);
        }
        $friend['member1_email'] = false;
        $friend['member1_phone'] = false;
        $friend['member2_email'] = false;
        $friend['member2_phone'] = false;
        $friend['status'] = '';
        $friend->save();
        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function shareSetting(Request $request, $memberID) {
        $user_id = auth()->id();
        $member = Member::query()
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->first(['id']);
        if (!$member) {
            return response()->json([
                'message' => 'Not found member.',
            ], 404);
        }
        $friend = MemberFriend::query()
            ->where(function ($query) use ($user_id, $member) {
                $query->where('member1_id', $user_id)
                    ->where('member2_id', $member['id']);
            })
            ->orWhere(function ($query) use ($user_id, $member) {
                $query->where('member1_id', $member['id'])
                    ->where('member2_id', $user_id);
            })
            ->where('status', 'accepted')
            ->firstOrNew();
        if (!$friend) {
            return response()->json([
                'message' => 'Not found request.'
            ], 404);
        }
        $email_share = !empty($request['email_share']);
        $phone_share = !empty($request['phone_share']);
        if ($friend['member1_id'] === $user_id) {
            $friend['member1_email'] = $email_share;
            $friend['member1_phone'] = $phone_share;
        } else {
            $friend['member2_email'] = $email_share;
            $friend['member2_phone'] = $phone_share;
        }
        $friend->save();
        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function remove(Request $request, $memberID) {
        $user_id = auth()->id();
        $member = Member::query()
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->first(['id']);
        if (!$member) {
            return response()->json([
                'message' => 'Not found member.',
            ], 404);
        }
        $friend = MemberFriend::query()
            ->where(function ($query) use ($user_id, $member) {
                $query->where('member1_id', $user_id)
                    ->where('member2_id', $member['id']);
            })
            ->orWhere(function ($query) use ($user_id, $member) {
                $query->where('member1_id', $member['id'])
                    ->where('member2_id', $user_id);
            })
            ->where('status', 'accepted')
            ->firstOrNew();
        if (!$friend) {
            return response()->json([
                'message' => 'Not found request.'
            ], 404);
        }
        $friend['member1_email'] = false;
        $friend['member1_phone'] = false;
        $friend['member2_email'] = false;
        $friend['member2_phone'] = false;
        $friend['status'] = '';
        $friend->save();
        return response()->json([
            'status' => 'OK'
        ]);
    }
}
