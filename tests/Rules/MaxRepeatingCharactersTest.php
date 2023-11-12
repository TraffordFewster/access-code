<?php

namespace Traffordfewster\AccessCode\Tests\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Traffordfewster\AccessCode\Rules\MaxRepeatingCharacters;

class MaxRepeatingCharactersTest extends TestCase
{
    use WithWorkbench;

    public function testPassesWhenBelowMaxRepeatingCharacters()
    {
        Validator::make(
            ['test' => 'abcde'],
            ['test' => new MaxRepeatingCharacters(3)]
        )->validate();

        $this->assertTrue(true);
    }

    public function testFailsWhenExceedsMaxRepeatingCharacters()
    {
        $results = fn () => Validator::make(
            ['test' => 'aaabbbccc'],
            ['test' => new MaxRepeatingCharacters(2)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must not contain more than 2 repeating characters.');
    }

    public function testPassesWhenEmptyString()
    {
        Validator::make(
            ['test' => ''],
            ['test' => new MaxRepeatingCharacters]
        )->validate();

        $this->assertTrue(true);
    }

    public function testPassesWhenValueIsNull()
    {
        Validator::make(
            ['test' => null],
            ['test' => new MaxRepeatingCharacters]
        )->validate();

        $this->assertTrue(true);
    }

    public function testPassesWhenBelowMaxRepeatingCharactersWithCustomMessage()
    {
        Validator::make(
            ['test' => 'abcde'],
            ['test' => new MaxRepeatingCharacters(3)]
        )->validate();

        $this->assertTrue(true);
    }

    public function testFailsWithCustomMessageWhenExceedsMaxRepeatingCharacters()
    {
        $results = fn () => Validator::make(
            ['test' => 'aaabbbccc'],
            ['test' => new MaxRepeatingCharacters(2)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must not contain more than 2 repeating characters.');
    }
}
