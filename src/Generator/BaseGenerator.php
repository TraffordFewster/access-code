<?php

namespace Traffordfewster\AccessCode\Generator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Traffordfewster\AccessCode\Exceptions\InvalidCodeException;
use Traffordfewster\AccessCode\Rules\MaxRepeatingCharacters;
use Traffordfewster\AccessCode\Rules\MaxSequenceLength;
use Traffordfewster\AccessCode\Rules\NoPalindrome;
use Traffordfewster\AccessCode\Rules\UniqueCharacters;

class BaseGenerator
{
    public function __construct(
        protected bool $numberOnly = true,
        protected int $length = 6,
        protected bool $allowPalindrome = false,
        protected int $maxRepeatingCharacters = 3,
        protected int $sequenceLength = 4,
        protected int $uniqueCharacters = 3,
    )
    {
        //
    }

    /**
     * Validate a value.
     *
     * @param  string $value The value to validate.
     * @return array The validated value.
     * @throws InvalidCodeException If the value is invalid.
     */
    public function validateValue(string $value): bool
    {
        try {
            Validator::make([
                'value' => $value,
            ], [
                'value' => [
                    'required',
                    'string',
                    $this->numberOnly ? "digits:$this->length" : "size:$this->length",
                    $this->numberOnly ? 'numeric' : 'alpha_num',
                    $this->allowPalindrome ? '' : new NoPalindrome,
                    'unique:access_codes,code',
                    new MaxRepeatingCharacters($this->maxRepeatingCharacters),
                    new MaxSequenceLength($this->sequenceLength),
                    new UniqueCharacters($this->uniqueCharacters),
                ],
            ], [
                'value.different' => 'The code must not be a palindrome.',
            ])->validate();
            
            return true;
        } catch (ValidationException $exception) {
            throw new InvalidCodeException($exception->getMessage());
        }
    }

    /**
     * Generate a code.
     *
     * @return string The code that was generated.
     */
    public function generateCode(): string
    {
        $code = '';

        while (strlen($code) < $this->length) {
            $code .= $this->numberOnly
                ? random_int(0, 9)
                : Str::random(1);
        }

        try {
            $this->validateValue($code);
        } catch (InvalidCodeException $exception) {
            return $this->generateCode();
        }

        return $code;
    }

    public function __toArray()
    {
        return [
            'numberOnly' => $this->numberOnly,
            'length' => $this->length,
            'allowPalindrome' => $this->allowPalindrome,
            'maxRepeatingCharacters' => $this->maxRepeatingCharacters,
            'sequenceLength' => $this->sequenceLength,
            'uniqueCharacters' => $this->uniqueCharacters,
        ];
    }

    public function __toString()
    {
        return json_encode($this->__toArray());
    }

    /**
     * Get the value of numberOnly
     *
     * @return boolean
     */
    public function getNumberOnly(): bool
    {
        return $this->numberOnly;
    }

    /**
     * Get the value of length
     *
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * Get the value of allowPalindrome
     *
     * @return boolean
     */
    public function getAllowPalindrome(): bool
    {
        return $this->allowPalindrome;
    }

    /**
     * Get the value of maxRepeatingCharacters
     *
     * @return int
     */
    public function getMaxRepeatingCharacters(): int
    {
        return $this->maxRepeatingCharacters;
    }

    /**
     * Get the value of sequenceLength
     *
     * @return int
     */
    public function getSequenceLength(): int
    {
        return $this->sequenceLength;
    }

    /**
     * Get the value of uniqueCharacters
     *
     * @return int
     */
    public function getUniqueCharacters(): int
    {
        return $this->uniqueCharacters;
    }
}