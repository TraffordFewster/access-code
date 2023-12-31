<?php

namespace Traffordfewster\AccessCode\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Traffordfewster\AccessCode\Exceptions\InvalidCodeException;
use Traffordfewster\AccessCode\Generator\BaseGenerator;

class AccessCode extends Model
{
    protected $guarded = [];

    /**
     * Get the owning model.
     *
     * @return MorphTo The owning model.
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if a string matches the code.
     *
     * @param  string $code The code to check.
     * @return bool Whether the code is valid.
     */
    public function checkCode(string $code): bool
    {
        return $code === $this->code;
    }

    /**
     * Generate a code.
     *
     * @param  BaseGenerator|null $generator The generator to use to generate the code.
     * @return string The code that was generated.
     */
    public function generateCode(BaseGenerator $generator = null): string
    {
        $generator ??= new BaseGenerator();

        $code = $generator->generateCode();

        $this->code = $code;
        $this->code_criteria = (string) $generator;

        return $code;
    }

    /**
     * Set the code manually.
     *
     * @param  string             $code The code to set.
     * @param  BaseGenerator|null $generator The generator to use to validate the code.
     * @return string The code that was set.
     * @throws InvalidCodeException If the code is invalid.
     */
    public function setCode(string $code, BaseGenerator $generator = null): string
    {
        $generator ??= new BaseGenerator();

        $generator->validateValue($code);

        $this->code = $code;
        $this->code_criteria = (string) $generator;

        return $code;
    }

    /**
     * Get the remaining codes based just on the length of the code.
     *
     * @return int The remaining codes.
     */
    public static function getRemainingCodes(BaseGenerator $generator = null): int
    {
        $generator ??= new BaseGenerator();
        $totalCodes = self::whereRaw('LENGTH(CODE) = ?', [$generator->getLength()])->count();
        $maxCodes = 10 ** $generator->getLength();
        return $maxCodes - $totalCodes - 1;
    }
}