<?php

namespace ContactBundle\Assembler;

use ContactBundle\DTO\ContactDto;
use ContactBundle\Entity\Contact;

class ContactAssembler
{
    public static function entityToDto(Contact $entity)
    {
        $dto = new ContactDto();

        $dto->setId($entity->getId())
            ->setFirstName($entity->getFirstName())
            ->setLastName($entity->getLastName())
            ->setCompany($entity->getCompany())
            ->setWebsite($entity->getWebsite())
            ->setNote($entity->getNote())
            ->setPhones(PhoneAssembler::entitiesToDtos($entity->getPhones()));

        return $dto;
    }

    public static function dtoToEntity($dto, $user)
    {
        $contact = new Contact();

        $contact->setFirstName($dto->getFirstName())
            ->setLastName($dto->getLastName())
            ->setCompany($dto->getCompany())
            ->setWebsite($dto->getWebsite())
            ->setNote($dto->getNote())
            ->setPhones(PhoneAssembler::dtosToEntities($dto->getPhones()))
            ->setUser($user);

        return $contact;
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
