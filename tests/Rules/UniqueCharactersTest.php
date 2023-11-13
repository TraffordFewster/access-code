<?php

namespace Traffordfewster\AccessCode\Tests\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Traffordfewster\AccessCode\Rules\UniqueCharacters;

class UniqueCharactersTest extends TestCase
{
    use WithWorkbench;

    public function testPassesWhenHasEnoughUniqueCharacters()
    {
        Validator::make(
            ['test' => 'abcde'],
            ['test' => new UniqueCharacters(3)]
        )->validate();

        $this->assertTrue(true);
    }

    public function testFailsWhenDoesNotHaveEnoughUniqueCharacters()
    {
        $results = fn () => Validator::make(
            ['test' => 'aaabbb'],
            ['test' => new UniqueCharacters(3)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must contain at least 3 unique characters.');
    }

    public function testFailsWithCustomMessageWhenDoesNotHaveEnoughUniqueCharacters()
    {
        $results = fn () => Validator::make(
            ['test' => 'aabbcc'],
            ['test' => new UniqueCharacters(5)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must contain at least 5 unique characters.');
    }

    public function testPassesWhenUsingNumbers()
    {
        Validator::make(
            ['test' => '12345'],
            ['test' => new UniqueCharacters(3)]
        )->validate();

        $this->assertTrue(true);
    }

    public function testFailsWhenUsingNumbers()
    {
        $results = fn () => Validator::make(
            ['test' => '111222'],
            ['test' => new UniqueCharacters(3)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must contain at least 3 unique characters.');
    }
}
