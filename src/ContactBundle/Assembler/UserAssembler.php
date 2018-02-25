<?php

namespace ContactBundle\Assembler;

use ContactBundle\Entity\User;
use ContactBundle\DTO\UserDto;

class UserAssembler
{
    public function entityToDto(User $entity)
    {
        $dto = new UserDto();

        $dto->setId($entity->getId())
            ->setUsername($entity->getUsername())
            ->setAvatar($entity->getAvatar())
            ->setBackground($entity->getBackground());

        return $dto;
    }

    public function dtoToEntity(UserDto $dto)
    {
        $user = new User();

        $user->setUsername($dto->getUsername())
            ->setPassword($dto->getPassword());

        return $user;
    }

    public function entitiesToDtos(array $entities)
    {
        $dtos = [];
        foreach ($entities as $entity) {
            $dtos[] = self::entityToDto($entity);
        }

        return $dtos;
    }
}
