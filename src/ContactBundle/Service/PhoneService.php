<?php

/**
 * File for the phone service. Use this class to return DTO from entities from
 * database.
 *
 * PHP version 7.1
 *
 * @category Phone
 * @package  ContactBundle\Service
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
namespace ContactBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;

use ContactBundle\Assembler\PhoneAssembler;
use ContactBundle\DTO\PhoneDto;

/**
 * Phone service. Use this class to return DTO from entities from
 * database.
 *
 * @category Phone
 * @package  ContactBundle\Service
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
class PhoneService
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
     * Repository for the Phone
     *
     * @var \ContactBundle\Repository\PhoneRepository
     */
    private $_phoneRepository;

    /**
     * Repository for the Contact
     *
     * @var \ContactBundle\Repository\ContactRepository
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
        $this->_phoneRepository = $this->_entityManager
            ->getRepository('ContactBundle:Phone');
        $this->_contactRepository = $this->_entityManager
            ->getRepository('ContactBundle:Contact');
    }

    /**
     * Method to create a phone from a DTO.
     *
     * @param Phone $phone The phone
     * @param integer $id The identifier of the contact.
     *
     * @return void
     */
    public function createPhone(PhoneDto $phone, $id): void
    {
        $phoneEntity = PhoneAssembler::dtoToEntity($phone);
        $contactEntity = $this->_contactRepository->findOneById($id);

        if ($contactEntity === null) {
            throw new ContactNotFoundException();
        }

        $contactEntity->addPhone($phoneEntity);

        $this->_entityManager->persist($phoneEntity);
        $this->_entityManager->persist($contactEntity);
        $this->_entityManager->flush();

        $phone->setId($phoneEntity->getId());
    }
}
