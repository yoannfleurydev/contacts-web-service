<?php

namespace ContactBundle\Assembler;

use ContactBundle\Entity\Phone;
use ContactBundle\DTO\PhoneDto;

class PhoneAssembler
{
    public static function entityToDto(Phone $phoneEntity)
    {
        $phoneDto = new PhoneDto();

        $phoneDto->setId($phoneEntity->getId())
            ->setNumber($phoneEntity->getNumber())
            ->setType($phoneEntity->getType());

        return $phoneDto;
    }

    public static function dtoToEntity($phoneDto): Phone
    {
        $phoneEntity = new Phone();

        $phoneEntity->setNumber($phoneDto->getNumber())
            ->setType($phoneDto->getType());

        return $phoneEntity;
    }

    public static function entitiesToDtos($entities)
    {
        $dtos = [];
        foreach ($entities as $entity) {
            $dtos[] = self::entityToDto($entity);
        }

        return $dtos;
    }

    public static function dtosToEntities($dtos)
    {
        $entities = [];
        foreach ($dtos as $dto) {
            $entities[] = self::dtoToEntity($dto);
        }

        return $entities;
    }

}
