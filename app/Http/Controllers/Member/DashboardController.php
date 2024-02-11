<?php

namespace App\Http\Controllers\Member;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function getRate($current, $prev) {
        return number_format(($current - $prev) / ($prev ?: 1) * 100, 1);
    }

    public function index(Request $request) {
        $s_time = strtotime($s = $request['s'] ?: date('01/01/Y'));
        $e_time = strtotime($e = $request['e'] ?: date('12/31/Y'));

        $plotting_start = date('Y-m-01 00:00:00', strtotime('-11 months'));
        $plotting_end = date('Y-m-31 23:59:59');
        $plotting_period = [$plotting_start, $plotting_end];
        $plotting_start_time = strtotime($plotting_start);
        $plotting_payments = [];
        for ($i = 0; $i < 12; $i++) {
            $month = date('M y', strtotime("+{$i} months", $plotting_start_time));
            $plotting_payments[$month] = 0;
        }

        $period_start = date('Y-m-d 00:00:00', $s_time);
        $period_end = date('Y-m-d 23:59:59', $e_time);
        $period = [$period_start, $period_end];
        $prev_period_start = date('Y-m-d 00:00:00', strtotime('-1 years', $s_time));
        $prev_period_end = date('Y-m-d 23:59:59', strtotime('-1 years', $e_time));
        $prev_period = [$prev_period_start, $prev_period_end];
        $payments = $prev_payments =
        $dues = $prev_dues =
        $food_beverage = $prev_food_beverage =
        $lessons = $prev_lessons =
        $rentals = $prev_rentals =
        $merchandise = $prev_merchandise = 0;

        $user = auth('member')->user();
        $invoices = Invoice::query()
            ->with([
                'activities' => function (HasMany $query) {
                    $query->whereIn('category', ['Food & Beverage', 'Lessons', 'Rentals', 'Merchandise']);
                },
            ])
            ->withSum('plans', 'price')
            ->where('member_id', $user['id'])
            ->where('paid', true)
            ->where(function (Builder $query) use ($plotting_period, $period, $prev_period) {
                $query->whereBetween('paid_at', $plotting_period)
                    ->orWhereBetween('paid_at', $period)
                    ->orWhereBetween('paid_at', $prev_period);
            })
            ->orderBy('paid_at')
            ->get();
        foreach ($invoices as $invoice) {
            $paid_at = $invoice['paid_at'];
            $invoice_amount = $invoice['amount'];
            $invoice_plans_price = $invoice['plans_sum_price'];
            if ($plotting_start <= $paid_at && $paid_at <= $plotting_end) {
                $month = date('M y', strtotime($paid_at));
                $plotting_payments[$month] += $invoice_amount;
            }
            $in_period = $period_start <= $paid_at && $paid_at <= $period_end;
            $in_prev_period = $prev_period_start <= $paid_at && $paid_at <= $prev_period_end;
            if ($in_period) {
                $payments += $invoice_amount;
                $dues += $invoice_plans_price;
            } else if ($in_prev_period) {
                $prev_payments += $invoice_amount;
                $prev_dues += $invoice_plans_price;
            }
            foreach ($invoice['activities'] as $activity) {
                $activity_price = $activity['price'];
                if ($activity['category'] == 'Food & Beverage') {
                    if ($in_period) $food_beverage += $activity_price;
                    else if ($in_prev_period) $prev_food_beverage += $activity_price;
                } else if ($activity['category'] == 'Lessons') {
                    if ($in_period) $lessons += $activity_price;
                    else if ($in_prev_period) $prev_lessons += $activity_price;
                } else if ($activity['category'] == 'Rentals') {
                    if ($in_period) $rentals += $activity_price;
                    else if ($in_prev_period) $prev_rentals += $activity_price;
                } else if ($activity['category'] == 'Merchandise') {
                    if ($in_period) $merchandise += $activity_price;
                    else if ($in_prev_period) $prev_merchandise += $activity_price;
                }
            }
        }
        return view('member.dashboard', [
            's' => $s,
            'e' => $e,
            'payments' => $payments,
            'payments_percent' => $this->getRate($payments, $prev_payments),
            'dues' => $dues,
            'dues_percent' => $this->getRate($dues, $prev_dues),
            'food_beverage' => $food_beverage,
            'food_beverage_percent' => $this->getRate($food_beverage, $prev_food_beverage),
            'lessons' => $lessons,
            'lessons_percent' => $this->getRate($lessons, $prev_lessons),
            'rentals' => $rentals,
            'rentals_percent' => $this->getRate($rentals, $prev_rentals),
            'merchandise' => $merchandise,
            'merchandise_percent' => $this->getRate($merchandise, $prev_merchandise),
            'plotting_payments' => $plotting_payments,
            'colors' => General::$colors,
        ]);
    }
}
