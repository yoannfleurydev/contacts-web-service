<?php

namespace Tests\ContactBundle\DTO;

use ContactBundle\DTO\PhoneDto;
use PHPUnit\Framework\TestCase;

class PhoneDtoTest extends TestCase
{
    public function testGetterSetter()
    {
        $phoneDto = new PhoneDto();
        $phoneDto->setId("id")
            ->setNumber("0200112233")
            ->setType(1);

        $this->assertEquals("id", $phoneDto->getId());
        $this->assertEquals("0200112233", $phoneDto->getNumber());
        $this->assertEquals(1, $phoneDto->getType());
    }

    public function testWrongGetterSetter()
    {
        $phoneDto = new PhoneDto();
        $phoneDto->setId("wrong")
            ->setNumber("wrong")
            ->setType(0);

        $this->assertNotEquals("id", $phoneDto->getId());
        $this->assertNotEquals("0200112233", $phoneDto->getNumber());
        $this->assertNotEquals(1, $phoneDto->getType());
    }
}
