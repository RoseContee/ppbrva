<?php

namespace App\Rules;

use App\Helpers\General;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class State implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array(strtoupper($value), array_keys(General::getStates()))) {
            $fail('The :attribute is invalid.');
        }
    }
}
