<?php

namespace Traffordfewster\AccessCode\Tests\Generator;

use Traffordfewster\AccessCode\Exceptions\InvalidCodeException;
use Traffordfewster\AccessCode\Generator\BaseGenerator;
use Traffordfewster\AccessCode\Tests\TestCase;

class BaseGeneratorTest extends TestCase
{
    protected BaseGenerator $generator;

    public function setUp(): void
    {
        parent::setUp();

        $this->generator = new BaseGenerator();
    }

    public function test_it_can_generate_a_code()
    {
        $code = $this->generator->generateCode();

        $this->assertIsString($code);
        $this->assertEquals($this->generator->getLength(), strlen($code));
    }

    public function test_generated_code_is_valid()
    {
        $code = $this->generator->generateCode();

        $this->assertTrue($this->generator->validateValue($code));
    }

    public function test_it_can_generate_numeric_code()
    {
        $generator = new BaseGenerator(numberOnly: true);

        $code = $generator->generateCode();

        $this->assertIsString($code);
        $this->assertEquals($generator->getLength(), strlen($code));
        $this->assertTrue(ctype_digit($code));
    }

    public function test_it_can_generate_alpha_numeric_code()
    {
        $generator = new BaseGenerator(numberOnly: false);

        $code = $generator->generateCode();

        $this->assertIsString($code);
        $this->assertEquals($generator->getLength(), strlen($code));
        $this->assertTrue(ctype_alnum($code));
    }

    public function test_it_allows_palindrome_codes()
    {
        $generator = new BaseGenerator(allowPalindrome: true);;

        $this->assertTrue($generator->validateValue('12344321'));
    }

    public function test_it_throws_exception_for_long_code()
    {
        $this->expectException(InvalidCodeException::class, 'The code must be 8 characters long.');

        $this->generator->validateValue('123456789');
    }

    public function test_it_throws_exception_for_short_code()
    {
        $this->expectException(InvalidCodeException::class, 'The code must be 8 characters long.');

        $this->generator->validateValue('1234567');
    }

    public function test_it_throws_exception_for_code_with_letters()
    {
        $this->expectException(InvalidCodeException::class, 'The code must only contain numbers.');

        $this->generator->validateValue('1234567a');
    }

    public function test_it_throws_exception_for_palindrome_code()
    {
        $this->expectException(InvalidCodeException::class, 'The code must not be a palindrome.');

        $this->generator->validateValue('12344321');
    }
}
