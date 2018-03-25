<?php

namespace Tests\ContactBundle\Assembler;

use ContactBundle\Assembler\PhoneAssembler;
use ContactBundle\DTO\PhoneDto;
use ContactBundle\Entity\Phone;
use PHPUnit\Framework\TestCase;

class PhoneAssemblerTest extends TestCase
{

    public function testEntityToDto()
    {
        $phone = new Phone();
        $phone
            ->setNumber("0000000000")
            ->setType("type");

        $phoneAssembler = new PhoneAssembler();
        $phoneDto = $phoneAssembler->entityToDto($phone);

        $this->assertEquals(null, $phoneDto->getId());
        $this->assertEquals("0000000000", $phoneDto->getNumber());
        $this->assertEquals("type", $phoneDto->getType());
    }

    public function testEntitiesToDtos()
    {
        $phone1 = new Phone();
        $phone1
            ->setNumber("0000000000")
            ->setType("type");

        $phoneAssembler = new PhoneAssembler();
        $phonesDto = $phoneAssembler->entitiesToDtos([$phone1]);

        $this->assertEquals(null, $phonesDto[0]->getId());
        $this->assertEquals("0000000000", $phonesDto[0]->getNumber());
        $this->assertEquals("type", $phonesDto[0]->getType());
    }

    public function testDtoToEntity()
    {
        $phoneDto = new PhoneDto();
        $phoneDto
            ->setNumber("0000000000")
            ->setType("type");

        $phoneAssembler = new PhoneAssembler();
        $phone = $phoneAssembler->dtoToEntity($phoneDto);

        $this->assertEquals(null, $phone->getId());
        $this->assertEquals("0000000000", $phone->getNumber());
        $this->assertEquals("type", $phone->getType());
    }

    public function testDtosToEntities()
    {
        $phoneDto1 = new PhoneDto();
        $phoneDto1
            ->setNumber("0000000000")
            ->setType("type");

        $phoneAssembler = new PhoneAssembler();
        $phones = $phoneAssembler->dtosToEntities([$phoneDto1]);

        $this->assertEquals(null, $phones[0]->getId());
        $this->assertEquals("0000000000", $phones[0]->getNumber());
        $this->assertEquals("type", $phones[0]->getType());
    }
}
