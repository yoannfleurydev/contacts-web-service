<?php

namespace Tests\ContactBundle\DTO;

use ContactBundle\DTO\ContactDto;
use ContactBundle\DTO\PhoneDto;
use PHPUnit\Framework\TestCase;

class ContactDtoTest extends TestCase
{
    public function testGetterSetter()
    {
        $phone = new PhoneDto();
        $phone->setId("1")
            ->setType(1)
            ->setNumber("0200112233");

        $contactDto = new ContactDto();
        $contactDto->setId("id")
            ->setCompany("company")
            ->setFirstName("firstname")
            ->setLastName("lastname")
            ->setNote("note")
            ->setWebsite("website")
            ->setPhones([$phone]);

        $this->assertEquals("id", $contactDto->getId());
        $this->assertEquals("company", $contactDto->getCompany());
        $this->assertEquals("firstname", $contactDto->getFirstName());
        $this->assertEquals("lastname", $contactDto->getLastName());
        $this->assertEquals("note", $contactDto->getNote());
        $this->assertEquals("website", $contactDto->getWebsite());
        $this->assertEquals([$phone], $contactDto->getPhones());
    }

    public function testWrongGetterSetter()
    {
        $phone = new PhoneDto();
        $phone->setId("1")
            ->setType(1)
            ->setNumber("0200112233");

        $contactDto = new ContactDto();
        $contactDto->setId("wrong")
            ->setCompany("wrong")
            ->setFirstName("wrong")
            ->setLastName("wrong")
            ->setNote("wrong")
            ->setWebsite("wrong")
            ->setPhones([]);

        $this->assertNotEquals("id", $contactDto->getId());
        $this->assertNotEquals("company", $contactDto->getCompany());
        $this->assertNotEquals("firstname", $contactDto->getFirstName());
        $this->assertNotEquals("lastname", $contactDto->getLastName());
        $this->assertNotEquals("note", $contactDto->getNote());
        $this->assertNotEquals("website", $contactDto->getWebsite());
        $this->assertNotEquals([$phone], $contactDto->getPhones());
    }
}
