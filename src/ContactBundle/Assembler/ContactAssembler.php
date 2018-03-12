<?php

namespace ContactBundle\Assembler;

use ContactBundle\DTO\ContactDto;
use ContactBundle\Entity\Contact;

class ContactAssembler
{
    /** @var PhoneAssembler $phoneAssembler */
    private $phoneAssembler;

    /**
     * ContactAssembler constructor.
     * @param PhoneAssembler $phoneAssembler
     */
    public function __construct(PhoneAssembler $phoneAssembler)
    {
        $this->phoneAssembler = $phoneAssembler;
    }


    public function entityToDto(Contact $entity)
    {
        $dto = new ContactDto();

        $dto->setId($entity->getId())
            ->setFirstName($entity->getFirstName())
            ->setLastName($entity->getLastName())
            ->setCompany($entity->getCompany())
            ->setWebsite($entity->getWebsite())
            ->setNote($entity->getNote())
            ->setPhones($this->phoneAssembler->entitiesToDtos($entity->getPhones()));

        return $dto;
    }

    public function dtoToEntity(ContactDto $dto, $user)
    {
        $contact = new Contact();

        $contact->setFirstName($dto->getFirstName())
            ->setLastName($dto->getLastName())
            ->setCompany($dto->getCompany())
            ->setWebsite($dto->getWebsite())
            ->setNote($dto->getNote())
            ->setPhones($this->phoneAssembler->dtosToEntities($dto->getPhones()))
            ->setUser($user);

        return $contact;
    }

    public function entitiesToDtos($entities)
    {
        $dtos = [];
        foreach ($entities as $entity) {
            $dtos[] = self::entityToDto($entity);
        }

        return $dtos;
    }
}
