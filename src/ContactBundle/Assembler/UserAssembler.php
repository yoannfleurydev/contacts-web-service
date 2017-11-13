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
            ->setPlainPassword($entity->getPlainPassword());

        return $dto;
    }

    public static function dtoToEntity($dto)
    {
        $user = new User();

        var_dump($dto);

        $user->setUsername($dto->getUsername())
            ->setPassword($dto->getPassword())
            ->setPlainPassword($dto->getPlainPassword());
        
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
