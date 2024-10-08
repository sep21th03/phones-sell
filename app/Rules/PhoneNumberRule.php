<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $number = str_replace(array('-', '.', ' '), '', $value);
        if (!preg_match('/^0[0-9]{9}$/', $number)) {
            $fail('Số điện thoại không hợp lệ.');
        }
    }
}

