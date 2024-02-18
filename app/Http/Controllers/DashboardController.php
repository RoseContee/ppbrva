<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Helpers\PodPlay;
use App\Models\Invoice;
use App\Models\Member;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $plans = Plan::query()
            ->withCount('members')
            ->has('members')
            ->where('price', '>', 0)
            ->get(['id', 'name', 'price']);

        $today = date('Y-m-d');
        $active_members = $with_cc = $paused_members = $suspended_members
            = $inactive_members = $pending_members = 0;
        $members = Member::query()
            ->get(['card_last4', 'status', 'pause_from', 'pause_to']);
        foreach ($members as $member) {
            if ($member['status'] == 'inactive') $inactive_members++;
            else if ($member['status'] == 'pending') $pending_members++;
            else if ($member['status'] == 'suspended') $suspended_members++;
            else if ($member['status'] == 'paused' && $member['pause_from'] <= $today && $today <= $member['pause_to']) {
                $paused_members++;
            } else {
                $active_members++;
                if ($member['card_last4']) $with_cc++;
            }
        }

        $labels = ['DUES', 'FOOD & BEV', 'PRO SHOP', 'TOURNAMENT', 'LEAGUE', 'EVENT', 'PODPLAY'];
        $s_time = strtotime($s = $request['s'] ?: date('01/01/Y'));
        $e_time = strtotime($e = $request['e'] ?: date('12/31/Y'));
        $period_start = date('Y-m-d 00:00:00', $s_time);
        $period_end = date('Y-m-d 23:59:59', $e_time);
        foreach ($labels as $label) $boxes[$label] = 0;
        $revenues = [];
        $i = 0;
        do {
            $i_time = strtotime("+{$i} months", $s_time);
            $month = date('M y', $i_time);
            foreach ($labels as $label) $revenues[$month][$label] = 0;
        } while (++$i < 12 || date('Y-m', $i_time) < date('Y-m', $e_time));

        $invoices = Invoice::query()
            ->with(['activities'])
            ->withSum('plans', 'price')
            ->where('paid', true)
            ->whereBetween('paid_at', [$period_start, $period_end])
            ->orderBy('paid_at')
            ->get();
        foreach ($invoices as $invoice) {
            $month = date('M y', strtotime($invoice['paid_at']));
            $boxes[$labels[0]] += ($price = $invoice['plans_sum_price']);
            $revenues[$month][$labels[0]] += $price;
            foreach ($invoice['activities'] as $activity) {
                if ($activity['from'] == 'clover'
                    || stripos($activity['category'], 'Food') !== false
                    || stripos($activity['category'], 'Beverage') !== false
                ) {
                    $boxes[$labels[1]] += ($price = $activity['price']);
                    $revenues[$month][$labels[1]] += $price;
                }
            }
        }

        $employee_payments = DB::table('employee_payments')
            ->whereBetween('created_at', [$period_start, $period_end])
            ->get();
        $employee_payments = json_decode(json_encode($employee_payments), true);
        foreach ($employee_payments as $payment) {
            $price = $payment['price'];
            $month = date('M y', strtotime($payment['created_at']));
            if ($payment['note'] == '') {
                $boxes[$labels[2]] += $price;
                $revenues[$month][$labels[2]] += $price;
            } else if ($payment['note'] == 'Tourney Fee') {
                $boxes[$labels[3]] += $price;
                $revenues[$month][$labels[3]] += $price;
            } else if ($payment['note'] == 'League Fee') {
                $boxes[$labels[4]] += $price;
                $revenues[$month][$labels[4]] += $price;
            } else if ($payment['note'] == 'Event Payment') {
                $boxes[$labels[5]] += $price;
                $revenues[$month][$labels[5]] += $price;
            }
        }
        $podplayClient = new PodPlay();
        $payments = $podplayClient->getRevenue($period_start, $period_end);
        foreach ($payments as $payment) {
            $month = date('M y', strtotime($payment['startTime']));
            $boxes[$labels[6]] += ($price = $payment['total'] / 100);
            $revenues[$month][$labels[6]] += $price;
        }

        return view('dashboard', [
            'colors' => General::$colors,
            'plans' => $plans,
            'active_members' => $active_members,
            'paused_members' => $paused_members,
            'suspended_members' => $suspended_members,
            'inactive_members' => $inactive_members,
            'pending_members' => $pending_members,
            'with_cc' => $with_cc,
            's' => $s,
            'e' => $e,
            'labels' => $labels,
            'boxes' => $boxes,
            'revenues' => $revenues,
        ]);
    }
}
