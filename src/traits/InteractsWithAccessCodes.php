<?php

namespace Traffordfewster\AccessCode\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Hash;
use Traffordfewster\AccessCode\Exceptions\InvalidCodeException;
use Traffordfewster\AccessCode\Generator\BaseGenerator;
use Traffordfewster\AccessCode\Models\AccessCode;

trait InteractsWithAccessCodes
{
    /**
     * Get the access codes.
     *
     * @return MorphMany The access codes.
     */
    public function accessCodes(): MorphMany
    {
        return $this->morphMany(AccessCode::class, 'model');
    }

    /**
     * Get the access code.
     *
     * @param  string $code The code to get.
     * @return AccessCode The access code.
     */
    public function getAccessCode(string $code): AccessCode
    {
        return $this->accessCodes()->where('code', $code)->firstOrFail();
    }

    /**
     * Generate an access code.
     *
     * @param  int|null $length The length of the code.
     * @return AccessCode The access code.
     */
    public function generateAccessCode(BaseGenerator $generator): AccessCode
    {
        $generator ??= new BaseGenerator();

        $accessCode = new AccessCode();

        $accessCode->generateCode($generator);

        $this->accessCodes()->save($accessCode);

        return $accessCode;
    }

    /**
     * Set the access code manually.
     *
     * @param  string             $code The code to set.
     * @param  BaseGenerator|null $generator The generator to use to validate the code.
     * @return AccessCode The access code.
     * @throws InvalidCodeException If the code is invalid.
     */
    public function setAccessCode(string $code, BaseGenerator $generator = null): AccessCode
    {
        $generator ??= new BaseGenerator();

        $accessCode = new AccessCode();

        $accessCode->setCode($code, $generator);

        $this->accessCodes()->save($accessCode);

        return $accessCode;
    }

    /**
     * Check if a string matches the access code.
     *
     * @param  string $code The code to check.
     * @return bool Whether the code is valid.
     */
    public function checkAccessCode(string $code): bool
    {
        return $this->checkAccessCodeHash(Hash::make($code));
    }

    /**
     * Check if a string matches the access code hash.
     *
     * @param  string $codeHash The code hash to check.
     * @return bool Whether the code is valid.
     */
    public function checkAccessCodeHash(string $codeHash): bool
    {
        return $this->accessCodes()->where('code', $codeHash)->exists();
    }

    /**
     * Delete an access code.
     *
     * @param  string $code The code to delete.
     * @return bool Whether the code was deleted.
     */
    public function deleteCode(string $code): bool
    {
        return $this->deleteCodeHash(Hash::make($code));
    }

    /**
     * Delete an access code hash.
     *
     * @param  string $codeHash The code hash to delete.
     * @return bool Whether the code was deleted.
     */
    public function deleteCodeHash(string $codeHash): bool
    {
        return $this->accessCodes()->where('code', $codeHash)->delete();
    }
}