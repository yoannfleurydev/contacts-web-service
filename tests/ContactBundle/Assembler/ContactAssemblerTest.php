<?php

namespace Tests\ContactBundle\Assembler;

use ContactBundle\Assembler\ContactAssembler;
use ContactBundle\Assembler\PhoneAssembler;
use ContactBundle\DTO\ContactDto;
use ContactBundle\Entity\Contact;
use ContactBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class ContactAssemblerTest extends TestCase
{

    public function testEntityToDto()
    {
        $phoneAssemblerMock = $this->createMock(PhoneAssembler::class);
        $phoneAssemblerMock->method("entitiesToDtos")->willReturn([]);

        $contact = new Contact();
        $contact
            ->setFirstName("firstname")
            ->setLastName("lastname")
            ->setWebsite("website")
            ->setNote("note")
            ->setCompany("company");

        $contactAssembler = new ContactAssembler($phoneAssemblerMock);
        $contactDto = $contactAssembler->entityToDto($contact);

        $this->assertEquals("firstname", $contactDto->getFirstName());
        $this->assertEquals("lastname", $contactDto->getLastName());
        $this->assertEquals("website", $contactDto->getWebsite());
        $this->assertEquals("note", $contactDto->getNote());
        $this->assertEquals("company", $contactDto->getCompany());
    }

    public function testDtoToEntity()
    {
        $phoneAssemblerMock = $this->createMock(PhoneAssembler::class);
        $phoneAssemblerMock->method("dtosToEntities")->willReturn([]);

        $contactDto = new ContactDto();
        $contactDto
            ->setFirstName("firstname")
            ->setLastName("lastname")
            ->setWebsite("website")
            ->setNote("note")
            ->setCompany("company");

        $contactAssembler = new ContactAssembler($phoneAssemblerMock);
        $contact = $contactAssembler->dtoToEntity($contactDto, new User());

        $this->assertEquals("firstname", $contact->getFirstName());
        $this->assertEquals("lastname", $contact->getLastName());
        $this->assertEquals("website", $contact->getWebsite());
        $this->assertEquals("note", $contact->getNote());
        $this->assertEquals("company", $contact->getCompany());
    }

    public function testEntitiesToDtos()
    {
        $phoneAssemblerMock = $this->createMock(PhoneAssembler::class);
        $phoneAssemblerMock->method("entitiesToDtos")->willReturn([]);

        $contact1 = new Contact();
        $contact1
            ->setFirstName("firstname")
            ->setLastName("lastname")
            ->setWebsite("website")
            ->setNote("note")
            ->setCompany("company");

        $contactAssembler = new ContactAssembler($phoneAssemblerMock);
        $contactsDto = $contactAssembler->entitiesToDtos([$contact1]);

        $this->assertEquals("firstname", $contactsDto[0]->getFirstName());
        $this->assertEquals("lastname", $contactsDto[0]->getLastName());
        $this->assertEquals("website", $contactsDto[0]->getWebsite());
        $this->assertEquals("note", $contactsDto[0]->getNote());
        $this->assertEquals("company", $contactsDto[0]->getCompany());
    }
}
