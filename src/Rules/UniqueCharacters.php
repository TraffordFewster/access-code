<?php

namespace Traffordfewster\AccessCode\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueCharacters implements ValidationRule
{
    public function __construct(protected int $neededUniqueCharacters = 3) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $uniqueCharacters = count(array_unique(str_split($value)));

        if ($uniqueCharacters < $this->neededUniqueCharacters) {
            $fail("The :attribute must contain at least $this->neededUniqueCharacters unique characters.");
        }
    }
}
