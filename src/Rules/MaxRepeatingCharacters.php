<?php

namespace Traffordfewster\AccessCode\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxRepeatingCharacters implements ValidationRule
{
    public function __construct(protected int $maxRepeatingCharacters = 3) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $repeatingCharacters = $this->getRepeatingCharacters($value ?? '');

        if ($repeatingCharacters && max($repeatingCharacters) >= $this->maxRepeatingCharacters) {
            $fail("The :attribute must not contain more than {$this->maxRepeatingCharacters} repeating characters.");
        }
    }

    public function getRepeatingCharacters(string $value): array
    {
        $repeatingCharacters = [];

        foreach (str_split($value) as $character) {
            isset($repeatingCharacters[$character]) ? $repeatingCharacters[$character]++ : $repeatingCharacters[$character] = 1;
        }

        return $repeatingCharacters;
    }
}
