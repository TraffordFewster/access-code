<?php

use Traffordfewster\AccessCode\Exceptions\InvalidCodeException;
use Traffordfewster\AccessCode\Generator\BaseGenerator;
use Traffordfewster\AccessCode\Tests\TestCase;
use Workbench\App\Models\TestModel;

class InteractsWithAccessCodesTest extends TestCase
{
    protected TestModel $testModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->testModel = new TestModel();
        $this->testModel->save();
    }

    public function test_it_returns_nothing_if_no_access_codes()
    {
        $this->assertEmpty($this->testModel->accessCodes);
    }

    public function test_it_generates_an_access_code()
    {
        $this->testModel->generateAccessCode();

        $this->assertCount(1, $this->testModel->accessCodes);
    }

    public function test_it_sets_an_access_code()
    {
        $this->testModel->setAccessCode('12345678');

        $this->assertCount(1, $this->testModel->accessCodes);
        $this->assertEquals('12345678', $this->testModel->accessCodes->first()->code);
    }

    public function test_delete_access_code()
    {
        $this->testModel->setAccessCode('12345678');

        $this->assertCount(1, $this->testModel->accessCodes);

        $this->testModel->deleteAccessCode('12345678');

        $this->assertCount(0, $this->testModel->accessCodes()->get());
    }

    public function test_cant_set_short_access_code()
    {
        $this->expectException(InvalidCodeException::class, 'The code must be 8 characters long.');

        $this->testModel->setAccessCode('1234567');
    }

    public function test_cant_set_long_access_code()
    {
        $this->expectException(InvalidCodeException::class, 'The code must be 8 characters long.');

        $this->testModel->setAccessCode('123456789');
    }

    public function test_cant_set_access_code_with_letters()
    {
        $this->expectException(InvalidCodeException::class, 'The code must only contain numbers.');

        $this->testModel->setAccessCode('1234567a');
    }

    public function test_cant_set_access_code_palindrome()
    {
        $this->expectException(InvalidCodeException::class, 'The code must not be a palindrome.');

        $this->testModel->setAccessCode('12344321');
    }

    public function test_can_set_longer_access_code_if_custom_generator()
    {
        $this->testModel->setAccessCode('123456789', new BaseGenerator(length: 9));

        $this->assertCount(1, $this->testModel->accessCodes);
        $this->assertEquals('123456789', $this->testModel->accessCodes->first()->code);
    }

    public function test_can_find_model_with_code()
    {
        $this->testModel->setAccessCode('12345678');

        $this->assertTrue(TestModel::findWithCode('12345678')->exists());
    }
}