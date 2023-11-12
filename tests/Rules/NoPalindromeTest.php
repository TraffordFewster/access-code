<?php 

namespace Traffordfewster\AccessCode\Tests\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Traffordfewster\AccessCode\Rules\NoPalindrome;

class NoPalindromeTest extends TestCase
{
    use WithWorkbench;

    public function testNonPalindromePasses()
    {
        Validator::make(
            ['test' => 'not a palindrome'],
            ['test' => new NoPalindrome]
        )->validate();

        $this->assertTrue(true);
    }

    public function testPalindromeFails()
    {
        $results = fn() => Validator::make(
            ['test' => 'racecar'],
            ['test' => new NoPalindrome]
        )->validate();

        $this->assertThrows($results, ValidationException::class, 'The test must not be a palindrome.');
    }
}