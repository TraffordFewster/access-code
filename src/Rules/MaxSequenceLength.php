<?php

namespace Traffordfewster\AccessCode\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxSequenceLength implements ValidationRule
{
    public function __construct(protected int $maxSequence = 3)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sequences = $this->getSequences($value ?? '');

        if (max($sequences) >= $this->maxSequence) {
            $fail("The :attribute must not contain more than {$this->maxSequence} sequential characters.");
        }
    }

    public function getSequences(string $value): array
    {
        $sequences = [];
        $previousCharacter = null;
        $sequenceLength = 0;
        $direction = null;

        foreach (str_split($value) as $character) {
            // if there is no previous character, set the previous character and continue
            if ($previousCharacter === null) {
                $previousCharacter = $character;
                continue;
            }

            // if the current character is the same as the previous character, continue
            if ($character === $previousCharacter) {
                continue;
            }

            // if the direction is null, check both directions
            if ($direction === null) {
                // check next character in the alphabet
                if (ord($character) === ord($previousCharacter) + 1) {
                    $direction = 1;
                    $sequenceLength = 2;
                    $previousCharacter = $character;
                    continue;
                }

                // check previous character in the alphabet
                if (ord($character) === ord($previousCharacter) - 1) {
                    $direction = -1;
                    $sequenceLength = 2;
                    $previousCharacter = $character;
                    continue;
                }
            }

            // if the direction is not null, check the direction
            if ($direction != null) {
                if (ord($character) === ord($previousCharacter) + $direction) {
                    $sequenceLength++;
                    $previousCharacter = $character;
                    continue;
                }
            }

            // add the sequence length to the sequences array
            $sequences[] = $sequenceLength;
            $sequenceLength = 0;
            $direction = null;
            $previousCharacter = $character;
        }

        $sequences[] = $sequenceLength;

        return $sequences;
    }
}
