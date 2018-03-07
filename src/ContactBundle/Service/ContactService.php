<?php

/**
 * File for the contact service. Use this class to return DTO from entities from
 * database.
 *
 * PHP version 7.1
 *
 * @category Contact
 * @package  ContactBundle\Service
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
namespace ContactBundle\Service;

use ContactBundle\Assembler\ContactAssembler;
use ContactBundle\DTO\ContactDto;
use ContactBundle\Entity\Contact;
use ContactBundle\Entity\User;
use ContactBundle\Exception\ContactNotFoundHttpException;
use ContactBundle\Repository\ContactRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;

/**
 * Contact service. Use this class to return DTO from entities from
 * database.
 *
 * @category Contact
 * @package  ContactBundle\Service
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
class ContactService
{
    /**
     * Logger to log the exceptions
     *
     * @var Logger
     */
    private $_logger;

    /**
     * Entity manager of Doctrine for Symfony Framework
     *
     * @var EntityManager The entity manager
     */
    private $_entityManager;

    /**
     * Repository for the contacts
     *
     * @var ContactRepository
     */
    private $_contactRepository;

    /**
     * Constructor of the contact service. It takes as parameters the logger
     * service and the entity manager of the application.
     *
     * @param Logger        $logger        The logger service.
     * @param EntityManager $entityManager The entity manager of the application.
     */
    public function __construct(Logger $logger, EntityManager $entityManager)
    {
        $this->_logger = $logger;
        $this->_entityManager = $entityManager;
        $this->_contactRepository = $this->_entityManager
            ->getRepository('ContactBundle:Contact');
    }

    /**
     * @param $id int The identifier of the contact to retrieve
     * @return ContactDto a contact DTO
     * @throws \Doctrine\ORM\ORMException
     */
    public function get($id): ContactDto
    {
        $contacts = $this->_contactRepository->findOneById($id);
        return ContactAssembler::entityToDto($contacts);
    }

    /**
     * Get all the contact as DTO.
     *
     * @return ContactDto[]
     */
    public function getAllContacts()
    {
        $contacts = $this->_contactRepository->findAll();
        return ContactAssembler::entitiesToDtos($contacts);
    }

    /**
     * Get the contact that match the given identifier.
     *
     * @param string $id   The identifier
     * @param User   $user The user, owner of the contact
     *
     * @return ContactDto The contact that matches with the given identifier.
     */
    public function getContactByUser($id, $user)
    {
        /** @var Contact $contact */
        $contact = $this->_contactRepository
            ->findOneBy(['id' => $id, 'user' => $user]);

        if ($contact === null) {
            throw new ContactNotFoundHttpException();
        }

        return ContactAssembler::entityToDto(
            $contact
        );
    }

    /**
     * Get all the contact as DTO.
     *
     * @return ContactDto[]
     */
    public function getAllContactsByUser($user)
    {
        return ContactAssembler::entitiesToDtos(
            $this->_contactRepository->findByUser($user)
        );
    }

    /**
     * Method to create a contact from a DTO.
     *
     * @param ContactDto $contact The contact
     * @param User $user
     *
     * @return Contact
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createContact(ContactDto $contact, User $user): Contact
    {
        $contactEntity = ContactAssembler::dtoToEntity($contact, $user);

        foreach($contactEntity->getPhones() as $phone) {
            $phone->setContact($contactEntity);
        }

        $this->_entityManager->persist($contactEntity);
        $this->_entityManager->flush();

        return $contactEntity;
    }

    public function deleteContact(Contact $contact): void
    {
        $this->_entityManager->remove($contact);
        $this->_entityManager->flush();
    }
}
