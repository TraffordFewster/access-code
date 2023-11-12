<?php

namespace Traffordfewster\AccessCode\Tests\Models;

use Traffordfewster\AccessCode\Exceptions\InvalidCodeException;
use Traffordfewster\AccessCode\Generator\BaseGenerator;
use Traffordfewster\AccessCode\Models\AccessCode;
use Traffordfewster\AccessCode\Tests\TestCase;
use Workbench\App\Models\TestModel;

class AccessCodeTest extends TestCase
{
    protected AccessCode $accessCode;

    public function setUp(): void
    {
        parent::setUp();

        $this->accessCode = new AccessCode();
    }

    public function test_it_has_empty_code_by_default()
    {
        $this->assertEmpty($this->accessCode->code);
    }

    public function test_it_belongs_to_a_model()
    {
        $relatedModel = TestModel::create();

        $this->accessCode->model_id = $relatedModel->id;
        $this->accessCode->model_type = get_class($relatedModel);

        $this->assertInstanceOf(TestModel::class, $this->accessCode->model);
    }

    public function test_it_can_check_valid_code()
    {
        $this->accessCode->code = '12345678';

        $this->assertTrue($this->accessCode->checkCode('12345678'));
        $this->assertFalse($this->accessCode->checkCode('87654321'));
    }

    public function test_it_can_generate_code()
    {
        $this->accessCode->generateCode();

        $this->assertNotEmpty($this->accessCode->code);
    }

    public function test_it_can_set_code()
    {
        $this->accessCode->setCode('12345678');

        $this->assertEquals('12345678', $this->accessCode->code);
    }

    public function test_it_throws_exception_for_invalid_code()
    {
        $this->expectException(InvalidCodeException::class);

        $this->accessCode->setCode('invalidcode');
    }
}
