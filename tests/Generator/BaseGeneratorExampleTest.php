<?php

namespace Traffordfewster\AccessCode\Tests\Generator;

use Traffordfewster\AccessCode\Exceptions\InvalidCodeException;
use Traffordfewster\AccessCode\Generator\BaseGenerator;
use Traffordfewster\AccessCode\Tests\TestCase;

class BaseGeneratorExampleTest extends TestCase
{
    protected BaseGenerator $generator;

    public function setUp(): void
    {
        parent::setUp();

        $this->generator = new BaseGenerator();
    }

    public function test_example_1_passes()
    {
        $this->assertTrue($this->generator->validateValue('494263'));
    }

    public function test_example_2_passes()
    {
        $this->assertTrue($this->generator->validateValue('791268'));
    }

    public function test_example_3_passes()
    {
        $this->assertTrue($this->generator->validateValue('003548'));
    }

    public function test_example_4_passes()
    {
        $this->assertTrue($this->generator->validateValue('977320'));
    }

    public function test_example_5_passes()
    {
        $this->assertTrue($this->generator->validateValue('325671'));
    }

    public function test_example_1_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('235532');
    }

    public function test_example_2_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('730037');
    }

    public function test_example_3_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('111135');
    }

    public function test_example_4_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('737797');
    }

    public function test_example_5_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('090300');
    }

    public function test_example_6_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('012386');
    }

    public function test_example_7_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('678931');
    }

    public function test_example_8_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('087653');
    }

    public function test_example_9_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('663633');
    }

    public function test_example_10_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('955959');
    }

    public function test_example_11_fails()
    {
        $this->expectException(InvalidCodeException::class);

        $this->generator->validateValue('454545');
    }
}