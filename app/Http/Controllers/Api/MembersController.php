<?php

namespace App\Http\Controllers\Api;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberFriend;
use App\Models\Plan;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MembersController extends Controller
{
    public function members() {
        $members = Member::query()
            ->with([
                'profile:member_id,share_age_gender,age,gender,rating,matches,wins,losses'
            ])
            ->where('id', '<>', auth()->id())
            ->where(function (Builder $query) {
                $query->where('plan_id', '<>', Plan::FamilyPlanId)
                    ->orWhere(function (Builder $query) {
                        $query->whereNull('is_child')
                            ->orWhere('is_child', '<>', true);
                    });
            })
            ->whereNotIn('status', ['inactive', 'pending'])
            ->get([
                'id', 'memberID', 'firstname', 'lastname', 'gender', 'dob', 'avatar'
            ]);
        foreach ($members as $member) {
            General::getGenderAge($member);
        }
        return response()->json([
            'members' => $members,
        ]);
    }

    public function friends() {
        $members = []; $pending_requests = 0;
        $user = Member::query()
            ->with([
                'friends1' => function (BelongsToMany $query) {
                    $query->with([
                        'profile:member_id,share_age_gender,age,gender,rating,matches,wins,losses'
                    ])
                        ->whereNotIn('members.status', ['inactive', 'pending'])
                        ->wherePivotIn('status', ['pending', 'accepted'])
                        ->withPivot('status')
                        ->select([
                            'members.id', 'memberID', 'firstname', 'lastname', 'gender', 'dob', 'avatar'
                        ]);
                },
                'friends2' => function (BelongsToMany $query) {
                    $query->with([
                        'profile:member_id,share_age_gender,age,gender,rating,matches,wins,losses'
                    ])
                        ->whereNotIn('members.status', ['inactive', 'pending'])
                        ->wherePivot('status', 'accepted')
                        ->withPivot('status')
                        ->select([
                            'members.id', 'memberID', 'firstname', 'lastname', 'gender', 'dob', 'avatar'
                        ]);
                },
            ])
            ->find(auth()->id(), ['id']);
        foreach ($user['friends1'] as $friend) {
            if ($friend['relation']['status'] == 'pending') $pending_requests++;
            else $members[] = $friend;
        }
        foreach ($user['friends2'] as $friend) {
            if ($friend['relation']['status'] == 'pending') $pending_requests++;
            else $members[] = $friend;
        }
        foreach ($members as $member) {
            General::getGenderAge($member);
        }
        return response()->json([
            'members' => $members,
            'pending_requests' => $pending_requests,
        ]);
    }

    public function pendingFriends() {
        $user = Member::query()
            ->with([
                'friends1' => function (BelongsToMany $query) {
                    $query->with([
                        'profile:member_id,share_age_gender,age,gender,rating,matches,wins,losses'
                    ])
                        ->whereNotIn('members.status', ['inactive', 'pending'])
                        ->wherePivot('status', 'pending')
                        ->withPivot('status')
                        ->select([
                            'members.id', 'memberID', 'firstname', 'lastname', 'gender', 'dob', 'avatar'
                        ]);
                },
            ])
            ->find(auth()->id(), ['id']);
        $members = $user['friends1'];
        foreach ($members as $member) {
            General::getGenderAge($member);
        }
        return response()->json([
            'members' => $members,
        ]);
    }

    public function member($memberID) {
        $user_id = auth()->id();
        $member = Member::query()
            ->with([
                'profile:member_id,share_age_gender,age,gender,rating,matches,wins,losses',
                'friends1' => function (BelongsToMany $query) use ($user_id) {
                    $query->wherePivot('member1_id', $user_id)
                        ->withPivot([
                            'member1_email', 'member1_phone', 'member2_email', 'member2_phone', 'status'
                        ])
                        ->select(['memberID']);
                },
                'friends2' => function (BelongsToMany $query) use ($user_id) {
                    $query->wherePivot('member2_id', $user_id)
                        ->withPivot([
                            'member1_email', 'member1_phone', 'member2_email', 'member2_phone', 'status'
                        ])
                        ->select(['memberID']);
                },
            ])
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->whereNotIn('status', ['inactive', 'pending'])
            ->first([
                'id', 'memberID', 'firstname', 'lastname', 'email', 'phone', 'gender', 'dob', 'avatar'
            ]);
        if (!$member) {
            return response()->json(['message' => 'Not found member.'], 404);
        }
        General::getGenderAge($member);
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
        $user = $request->user();
        $user_id = $user['id'];
        $member = Member::query()
            ->with(['devices'])
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->whereNotIn('status', ['inactive', 'pending'])
            ->first(['id']);
        if (!$member) {
            return response()->json(['message' => 'Not found member.'], 404);
        }
        $friend = MemberFriend::query()
            ->where(function (Builder $query) use ($user_id, $member) {
                $query->where('member1_id', $user_id)
                    ->where('member2_id', $member['id']);
            })
            ->orWhere(function (Builder $query) use ($user_id, $member) {
                $query->where('member1_id', $member['id'])
                    ->where('member2_id', $user_id);
            })
            ->firstOrNew();
        if ($friend['status']) {
            return response()->json(['message' => 'Cannot request a friend at the moment.'], 403);
        }
        try {
            $devices = [];
            foreach ($member['devices'] as $device) {
                $devices[] = $device['token'];
            }
            if (!empty($devices)) {
                $response = Http::withHeaders([
                    'Authorization' => 'key='.env('FIREBASE_SERVER_KEY'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post('https://fcm.googleapis.com/fcm/send', [
                    'registration_ids' => $devices,
                    'notification' => [
                        'title' => 'New friend request',
                        'body' => "{$user['name']} wants to be your friend!",
                    ]
                ]);
                $result = json_encode($response->body(), true);
            }
        } catch (RequestException $exception) {
            $result = json_decode($exception->getResponse()->getBody(), true);
        } catch (\Exception $exception) {
            $result = $exception->getMessage();
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
            ->whereNotIn('status', ['inactive', 'pending'])
            ->first(['id']);
        if (!$member) {
            return response()->json(['message' => 'Not found member.'], 404);
        }
        $friend = MemberFriend::query()
            ->where('member1_id', $member['id'])
            ->where('member2_id', $user_id)
            ->where('status', 'pending')
            ->first();
        if (!$friend) {
            return response()->json(['message' => 'Not found request.'], 404);
        }
        $friend['member2_email'] = !empty($request['email_share']);
        $friend['member2_phone'] = !empty($request['phone_share']);
        $friend['status'] = 'accepted';
        $friend->save();
        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function decline($memberID) {
        $user_id = auth()->id();
        $member = Member::query()
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->whereNotIn('status', ['inactive', 'pending'])
            ->first(['id']);
        if (!$member) {
            return response()->json(['message' => 'Not found member.'], 404);
        }
        $friend = MemberFriend::query()
            ->where('member1_id', $member['id'])
            ->where('member2_id', $user_id)
            ->where('status', 'pending')
            ->first();
        if (!$friend) {
            return response()->json(['message' => 'Not found request.'], 404);
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
            ->whereNotIn('status', ['inactive', 'pending'])
            ->first(['id']);
        if (!$member) {
            return response()->json(['message' => 'Not found member.'], 404);
        }
        $friend = MemberFriend::query()
            ->where(function (Builder $query) use ($user_id, $member) {
                $query->where('member1_id', $user_id)
                    ->where('member2_id', $member['id']);
            })
            ->orWhere(function (Builder $query) use ($user_id, $member) {
                $query->where('member1_id', $member['id'])
                    ->where('member2_id', $user_id);
            })
            ->where('status', 'accepted')
            ->first();
        if (!$friend) {
            return response()->json(['message' => 'Not found request.'], 404);
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

    public function remove($memberID) {
        $user_id = auth()->id();
        $member = Member::query()
            ->where('memberID', $memberID)
            ->where('id', '<>', $user_id)
            ->whereNotIn('status', ['inactive', 'pending'])
            ->first(['id']);
        if (!$member) {
            return response()->json(['message' => 'Not found member.'], 404);
        }
        $friend = MemberFriend::query()
            ->where(function (Builder $query) use ($user_id, $member) {
                $query->where('member1_id', $user_id)
                    ->where('member2_id', $member['id']);
            })
            ->orWhere(function (Builder $query) use ($user_id, $member) {
                $query->where('member1_id', $member['id'])
                    ->where('member2_id', $user_id);
            })
            ->where('status', 'accepted')
            ->first();
        if (!$friend) {
            return response()->json(['message' => 'Not found friend.'], 404);
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
