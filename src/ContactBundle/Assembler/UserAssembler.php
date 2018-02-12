<?php

namespace ContactBundle\Assembler;

use ContactBundle\Entity\User;
use ContactBundle\DTO\UserDto;

class UserAssembler
{
    public static function entityToDto(User $entity)
    {
        $dto = new UserDto();

        $dto->setId($entity->getId())
            ->setUsername($entity->getUsername())
            ->setPassword($entity->getPassword())
            ->setAvatar($entity->getAvatar())
            ->setBackground($entity->getBackground());

        return $dto;
    }

    public static function dtoToEntity($dto)
    {
        $user = new User();

        $user->setUsername($dto->getUsername())
            ->setPassword($dto->getPassword());

        return $user;
    }

    public static function entitiesToDtos($entities)
    {
        $dtos = [];
        foreach ($entities as $entity) {
            $dtos[] = self::entityToDto($entity);
        }

        return $dtos;
    }
}
