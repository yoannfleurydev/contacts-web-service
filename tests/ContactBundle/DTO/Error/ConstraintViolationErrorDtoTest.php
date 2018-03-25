<?php

namespace Tests\ContactBundle\DTO\Error;

use ContactBundle\DTO\Error\ConstraintViolationErrorDto;
use PHPUnit\Framework\TestCase;

class ConstraintViolationErrorDtoTest extends TestCase
{
    public function testGetterSetter()
    {
        $constraintViolationErrorDto = new ConstraintViolationErrorDto();
        $constraintViolationErrorDto
            ->setCode("code")
            ->setKey("key")
            ->setMessage("message");

        $this->assertEquals("code", $constraintViolationErrorDto->getCode());
        $this->assertEquals("key", $constraintViolationErrorDto->getKey());
        $this->assertEquals("message", $constraintViolationErrorDto->getMessage());
    }

    public function testWrongGetterSetter()
    {
        $constraintViolationErrorDto = new ConstraintViolationErrorDto();
        $constraintViolationErrorDto
            ->setCode("wrong")
            ->setKey("wrong")
            ->setMessage("wrong");

        $this->assertNotEquals("code", $constraintViolationErrorDto->getCode());
        $this->assertNotEquals("key", $constraintViolationErrorDto->getKey());
        $this->assertNotEquals("message", $constraintViolationErrorDto->getMessage());
    }
}
