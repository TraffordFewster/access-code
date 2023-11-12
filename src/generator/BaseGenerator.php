<?php

namespace Traffordfewster\AccessCode\Generator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Traffordfewster\AccessCode\Rules\NoPalindrome;

class BaseGenerator
{
    public function __construct(
        protected bool $numberOnly = true,
        protected int $length = 8,
        protected bool $allowPalindrome = false
    )
    {
        //
    }

    /**
     * Validate a value.
     *
     * @param  string $value The value to validate.
     * @return array The validated value.
     */
    public function validateValue(string $value): array
    {
        return Validator::make([
            'value' => $value,
        ], [
            'value' => [
                'required',
                'string',
                $this->numberOnly ? "digits:$this->length" : "size:$this->length",
                // "max:$this->length",
                $this->numberOnly ? 'numeric' : 'alpha_num',
                $this->allowPalindrome ? '' : new NoPalindrome,
                'unique:access_codes,code'
            ],
        ], [
            'value.different' => 'The code must not be a palindrome.',
        ])->validate();
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

        if ($errors = $this->validateValue($code) && !empty($errors)) {
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
        ];
    }

    public function __toString()
    {
        return json_encode($this->__toArray());
    }
}