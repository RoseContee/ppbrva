<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected function getRate($current, $prev) {
        return number_format(($current - $prev) / ($prev ?: 1) * 100, 1);
    }

    public function index(Request $request) {
        if (!$request['s']) $request['s'] = date('01/01/Y');
        if (!$request['e']) $request['e'] = date('12/31/Y');
        $start_date = date('Y-m-d 00:00:00', strtotime($request['s']));
        $end_date = date('Y-m-d 23:59:59', strtotime($request['e']));
        $prev_start_date = date('Y-m-d 00:00:00', strtotime('-1 years', strtotime($request['s'])));
        $prev_end_date = date('Y-m-d 23:59:59', strtotime('-1 years', strtotime($request['e'])));
        $period_start = date('Y-m-01 00:00:00', strtotime('-11 months'));
        $period_end = date('Y-m-31 23:59:59');
        $users = Member::query()
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orWhereBetween('created_at', [$prev_start_date, $prev_end_date])
            ->get();
        $invoices = Invoice::query()
            ->with([
                'activities' => function ($query) {
                    $query->whereIn('category', ['Lessons', 'Food & Beverage', 'Rentals']);
                },
            ])
            ->where('paid', true)
            ->where(function ($query) use ($start_date, $end_date, $prev_start_date, $prev_end_date, $period_start, $period_end) {
                $query->whereBetween('paid_at', [$start_date, $end_date])
                    ->orWhereBetween('paid_at', [$prev_start_date, $prev_end_date])
                    ->orWhereBetween('paid_at', [$period_start, $period_end]);
            })
            ->orderBy('paid_at')
            ->get();
        $members = $prev_members =
        $payments = $prev_payments =
        $dues = $prev_dues =
        $lessons = $prev_lessons =
        $food_beverage = $prev_food_beverage =
        $rentals = $prev_rentals = 0;
        foreach ($users as $user) {
            if ($start_date <= $user['created_at'] && $user['created_at'] <= $end_date) $members++;
            else $prev_members++;
        }
        $plotting_payments = [];
        for ($i = 0; $i < 12; $i++) {
            $plotting_payments[date('Y-m', strtotime("+{$i} months", strtotime($period_start)))] = 0;
        }
        foreach ($invoices as $invoice) {
            if ($start_date <= $invoice['paid_at'] && $invoice['paid_at'] <= $end_date) {
                $payments += $invoice['amount'];
                $dues += $invoice['plan_price'];
                foreach ($invoice['activities'] as $activity) {
                    if ($activity['category'] == 'Lessons') $lessons += $activity['price'];
                    else if ($activity['category'] == 'Food & Beverage') $food_beverage += $activity['price'];
                    else if ($activity['category'] == 'Rentals') $rentals += $activity['price'];
                }
            } else if ($prev_start_date <= $invoice['paid_at'] && $invoice['paid_at'] <= $prev_end_date) {
                $prev_payments += $invoice['amount'];
                $prev_dues += $invoice['plan_price'];
                foreach ($invoice['activities'] as $activity) {
                    if ($activity['category'] == 'Lessons') $prev_lessons += $activity['price'];
                    else if ($activity['category'] == 'Food & Beverage') $prev_food_beverage += $activity['price'];
                    else if ($activity['category'] == 'Rentals') $prev_rentals += $activity['price'];
                }
            }
            if ($period_start <= $invoice['paid_at'] && $invoice['paid_at'] <= $period_end) {
                $plotting_payments[date('Y-m', strtotime($invoice['paid_at']))] += $invoice['amount'];
            }
        }
        return view('dashboard', [
            's' => $request['s'],
            'e' => $request['e'],
            'members' => $members,
            'members_percent' => $this->getRate($members, $prev_members),
            'payments' => $payments,
            'payments_percent' => $this->getRate($payments, $prev_payments),
            'dues' => $dues,
            'dues_percent' => $this->getRate($dues, $prev_dues),
            'lessons' => $lessons,
            'lessons_percent' => $this->getRate($lessons, $prev_lessons),
            'food_beverage' => $food_beverage,
            'food_beverage_percent' => $this->getRate($food_beverage, $prev_food_beverage),
            'rentals' => $rentals,
            'rentals_percent' => $this->getRate($rentals, $prev_rentals),
            'plotting_payments' => $plotting_payments,
        ]);
    }
}
