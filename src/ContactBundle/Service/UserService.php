<?php
namespace ContactBundle\Service;

use ContactBundle\DTO\Error\ConstraintViolationErrorDto;
use ContactBundle\Entity\User;
use ContactBundle\Exception\ConstraintViolationException;
use ContactBundle\Exception\UserConflictHttpException;
use ContactBundle\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


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
     * Validator
     *
     * @var ValidatorInterface $_validator
     */
    private $_validator;

    /**
     * Serializer
     *
     * @var Serializer $_serializer
     */
    private $_serializer;

    /**
     * The path to the avatars directory.
     *
     * @var string
     */
    private $_avatarsDirectory;

    /**
     * The path to the backgrounds directory.
     *
     * @var string
     */
    private $_backgroundsDirectory;

    /**
     * Constructor of the contact service. It takes as parameters the logger
     * service and the entity manager of the application.
     *
     * @param Logger $logger The logger service.
     * @param EntityManager $entityManager The entity manager of the application.
     * @param UserPasswordEncoderInterface $encoder The entity manager of the application.
     * @param ValidatorInterface $validator The validator to validate the entity.
     * @param Serializer $serializer The serializer for thrown exception.
     * @param string $avatarsDirectory The path to the avatars directory.
     * @param string $backgroundsDirectory The path to the backgrounds directory.
     */
    public function __construct(
        Logger $logger,
        EntityManager $entityManager,
        UserPasswordEncoderInterface $encoder,
        ValidatorInterface $validator,
        Serializer $serializer,
        $avatarsDirectory,
        $backgroundsDirectory
    )
    {
        $this->_logger = $logger;
        $this->_entityManager = $entityManager;
        $this->_encoder = $encoder;
        $this->_validator = $validator;
        $this->_serializer = $serializer;
        $this->_avatarsDirectory = $avatarsDirectory;
        $this->_backgroundsDirectory = $backgroundsDirectory;
        $this->_userRepository = $this->_entityManager
            ->getRepository('ContactBundle:User');
    }

    public function get($id): User
    {
        return $this->_userRepository->findOneById($id);
    }

    /**
     * Method to create a user from a DTO.
     *
     * @param User $user The user
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUser(User $user): void
    {
        /** @var ConstraintViolationListInterface $constraintViolationList */
        $constraintViolationList = $this->_validator->validate($user);
        if ($constraintViolationList->count() > 0) {
            $constraintViolationDtoList = ConstraintViolationErrorDto::fromConstraintViolationList($constraintViolationList);
            throw ConstraintViolationException::fromConstraintViolationErrorList($constraintViolationDtoList, $this->_serializer);
        }

        $plainPassword = $user->getPassword();
        $user->setPassword(
            $this->_encoder->encodePassword($user, $plainPassword)
        );

        try {
            $this->_entityManager->persist($user);
            $this->_entityManager->flush();
        } catch (UniqueConstraintViolationException $ucve) {
            throw new UserConflictHttpException();
        }

        $user->setId($user->getId());
    }

    public function setAvatar(UploadedFile $avatar, User $user)
    {
        $user->setAvatar($user->getId() . '.' . $avatar->guessExtension());
        $avatar->move($this->_avatarsDirectory, $user->getAvatar());

        $this->_entityManager->persist($user);
        $this->_entityManager->flush();
    }

    public function setBackground(UploadedFile $background, User $user)
    {
        $user->setBackground($user->getId() . '.' . $background->guessExtension());
        $background->move($this->_backgroundsDirectory, $user->getBackground());

        $this->_entityManager->persist($user);
        $this->_entityManager->flush();
    }

    public function deleteUser($id): void
    {
        $userEntity = $this->_userRepository->findOneById($id);

        $this->_entityManager->remove($userEntity);
        $this->_entityManager->flush();
    }
}
