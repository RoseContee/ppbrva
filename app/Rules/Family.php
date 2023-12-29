<?php

namespace App\Rules;

use App\Helpers\General;
use App\Models\Member;
use App\Models\Setting;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;

class Family implements ValidationRule
{
    protected $memberId = null;

    public function __construct($memberId = null) {
        $this->memberId = $memberId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secondary_limit = Setting::getSetting('secondary_limit', 5);
        $query = Member::query();
        if ($this->memberId) {
            $query = $query->whereHas('secondaries', function (Builder $query) {
                $query->where('id', '<>', $this->memberId);
            }, '<', $secondary_limit);
        } else {
            $query = $query->has('secondaries', '<', $secondary_limit);
        }
        $member = $query->where('id', $value)
            ->where('plan_id', General::$FamilyPlanId)
            ->whereNull('primary_id')
            ->first();
        if (!$member) {
            $fail('The :attribute must be primary member.');
        }
    }
}
