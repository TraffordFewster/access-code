<?php

namespace Traffordfewster\AccessCode\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoPalindrome implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strrev($value) === $value) {
            $fail('The :attribute must not be a palindrome.');
        }
    }
}