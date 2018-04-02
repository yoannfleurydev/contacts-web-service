<?php

namespace ContactBundle\Assembler;

use ContactBundle\DTO\UserDto;
use ContactBundle\Entity\User;

class UserAssembler
{
    private $avatarDirectory;
    private $backgroundDirectory;

    /**
     * UserAssembler constructor.
     * @param $avatarDirectory
     * @param $backgroundDirectory
     */
    public function __construct($avatarDirectory, $backgroundDirectory)
    {
        $this->avatarDirectory = "/" . implode("/", array_slice(explode("/", $avatarDirectory), 2));
        $this->backgroundDirectory = "/" . implode("/", array_slice(explode("/", $backgroundDirectory), 2));
    }


    public function entityToDto(User $entity)
    {
        $dto = new UserDto();

        $dto->setId($entity->getId())
            ->setUsername($entity->getUsername())
            ->setAvatar($this->avatarDirectory . "/" . $entity->getAvatar())
            ->setBackground($this->backgroundDirectory . "/" . $entity->getBackground());

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
