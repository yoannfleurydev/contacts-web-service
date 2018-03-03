<?php

namespace Tests\ContactBundle\DTO;

use ContactBundle\DTO\PhoneDto;
use PHPUnit\Framework\TestCase;

class PhoneDtoTest extends TestCase
{
    public function testGetterSetter()
    {
        $userDto = new PhoneDto();
        $userDto->setId("id")
            ->setNumber("0200112233")
            ->setType(1);

        $this->assertEquals("id", $userDto->getId());
        $this->assertEquals("0200112233", $userDto->getNumber());
        $this->assertEquals(1, $userDto->getType());
    }

    public function testWrongGetterSetter()
    {
        $userDto = new PhoneDto();
        $userDto->setId("wrong")
            ->setNumber("wrong")
            ->setType(0);

        $this->assertNotEquals("id", $userDto->getId());
        $this->assertNotEquals("0200112233", $userDto->getNumber());
        $this->assertNotEquals(1, $userDto->getType());
    }
}
