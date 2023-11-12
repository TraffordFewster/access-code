<?php

namespace Traffordfewster\AccessCode\Tests\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Traffordfewster\AccessCode\Rules\MaxSequenceLength;

class MaxSequenceLengthTest extends TestCase
{
    use WithWorkbench;

    public function testPassesWhenBelowMaxSequenceLength()
    {
        Validator::make(
            ['test' => 'abde'],
            ['test' => new MaxSequenceLength(3)]
        )->validate();

        $this->assertTrue(true);
    }

    public function testFailsWhenExceedsMaxSequenceLength()
    {
        $results = fn () => Validator::make(
            ['test' => 'abc'],
            ['test' => new MaxSequenceLength(3)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must not contain more than 3 sequential characters.');
    }

    public function testFailsWhenExceedsMaaxSequenceLengthBackwards()
    {
        $results = fn () => Validator::make(
            ['test' => 'cba'],
            ['test' => new MaxSequenceLength(3)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must not contain more than 3 sequential characters.');
    }

    public function testPassesWhenEmptyString()
    {
        Validator::make(
            ['test' => ''],
            ['test' => new MaxSequenceLength]
        )->validate();

        $this->assertTrue(true);
    }

    public function testPassesWhenValueIsNull()
    {
        Validator::make(
            ['test' => null],
            ['test' => new MaxSequenceLength]
        )->validate();

        $this->assertTrue(true);
    }

    public function testFailsWithCustomMessageWhenExceedsMaxSequenceLength()
    {
        $results = fn () => Validator::make(
            ['test' => 'abcde123fghijk'],
            ['test' => new MaxSequenceLength(5)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must not contain more than 5 sequential characters.');
    }

    public function testPassesWhenBelowMaxSequenceLengthWithNumbers()
    {
        Validator::make(
            ['test' => '124'],
            ['test' => new MaxSequenceLength(3)]
        )->validate();

        $this->assertTrue(true);
    }

    public function testFailsWhenExceedsMaxSequenceLengthWithNumbers()
    {
        $results = fn () => Validator::make(
            ['test' => '123'],
            ['test' => new MaxSequenceLength(3)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must not contain more than 3 sequential characters.');
    }

    public function testFailsWhenExceedsMaxSequenceLengthWithNumbersBackwards()
    {
        $results = fn () => Validator::make(
            ['test' => '321'],
            ['test' => new MaxSequenceLength(3)]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must not contain more than 3 sequential characters.');
    }
}
