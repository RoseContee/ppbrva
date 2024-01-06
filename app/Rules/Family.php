<?php

namespace App\Rules;

use App\Models\Member;
use App\Models\Plan;
use App\Models\Setting;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;

class Family implements ValidationRule
{
    protected string|null $memberId = null;

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
        $secondary_limit = Setting::getSetting('secondary_limit', Setting::DefaultSecondaryLimit);
        $query = Member::query();
        if ($this->memberId) {
            $query = $query->whereHas('families', function (Builder $query) {
                $query->where('id', '<>', $this->memberId);
            }, '<', $secondary_limit);
        } else {
            $query = $query->has('families', '<', $secondary_limit);
        }
        $member = $query->where('plan_id', Plan::FamilyPlanId)
            ->whereNull('primary_id')
            ->find($value);
        if (!$member) {
            $fail('The :attribute must be primary member.');
        }
    }
}
