<?php
namespace ContactBundle\Service;

use ContactBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;

use ContactBundle\Assembler\UserAssembler;
use ContactBundle\DTO\UserDto;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserService
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
     * @var UserRepository
     */
    private $_userRepository;

    /**
     * Password Encoder
     *
     * @var UserPasswordEncoderInterface $encoder
     */
    private $_encoder;

    /**
     * Constructor of the contact service. It takes as parameters the logger
     * service and the entity manager of the application.
     *
     * @param Logger        $logger        The logger service.
     * @param EntityManager $entityManager The entity manager of the application.
     * @param UserPasswordEncoderInterface $encoder The entity manager of the application.
     */
    public function __construct(Logger $logger, EntityManager $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->_logger = $logger;
        $this->_entityManager = $entityManager;
        $this->_encoder = $encoder;
        $this->_userRepository = $this->_entityManager
            ->getRepository('ContactBundle:User');
    }

    public function get($id): UserDto
    {
        $user = $this->_userRepository->findOneById($id);
        return UserAssembler::entityToDto($user);
    }

    /**
     * Method to create a user from a DTO.
     *
     * @param UserDto $user The user
     * @return void
     */
    public function createUser(UserDto $user): void
    {
        $userEntity = UserAssembler::dtoToEntity($user);

        $plainPassword = $userEntity->getPassword();
        $encoded = $this->_encoder->encodePassword($userEntity, $plainPassword);
        $userEntity->setPassword($encoded);

        $this->_entityManager->persist($userEntity);
        $this->_entityManager->flush();

        $user->setId($userEntity->getId());
    }

    public function deleteUser($id): void
    {
        $userEntity = $this->_userRepository->findOneById($id);

        $this->_entityManager->remove($userEntity);
        $this->_entityManager->flush();
    }
}
