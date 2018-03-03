<?php

namespace ContactBundle\Assembler;

use ContactBundle\DTO\PhoneDto;
use ContactBundle\Entity\Phone;

class PhoneAssembler
{
    public function entityToDto(Phone $phoneEntity)
    {
        $phoneDto = new PhoneDto();

        $phoneDto->setId($phoneEntity->getId())
            ->setNumber($phoneEntity->getNumber())
            ->setType($phoneEntity->getType());

        return $phoneDto;
    }

    public function dtoToEntity($phoneDto): Phone
    {
        $phoneEntity = new Phone();

        $phoneEntity->setNumber($phoneDto->getNumber())
            ->setType($phoneDto->getType());

        return $phoneEntity;
    }

    public function entitiesToDtos($entities)
    {
        $dtos = [];
        foreach ($entities as $entity) {
            $dtos[] = self::entityToDto($entity);
        }

        return $dtos;
    }

    public function dtosToEntities($dtos)
    {
        $entities = [];

        if ($dtos) {
            foreach ($dtos as $dto) {
                $entities[] = self::dtoToEntity($dto);
            }
        }

        return $entities;
    }

}
