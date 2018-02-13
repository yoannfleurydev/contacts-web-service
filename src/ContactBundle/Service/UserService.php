<?php
namespace ContactBundle\Service;

use ContactBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;

use ContactBundle\Assembler\UserAssembler;
use ContactBundle\DTO\UserDto;
use ContactBundle\Exception\UserConflictHttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


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
     * @param Logger        $logger        The logger service.
     * @param EntityManager $entityManager The entity manager of the application.
     * @param UserPasswordEncoderInterface $encoder The entity manager of the application.
     * @param string $avatarsDirectory     The path to the avatars directory.
     * @param string $backgroundsDirectory The path to the backgrounds directory.
     */
    public function __construct(
        Logger $logger,
        EntityManager $entityManager,
        UserPasswordEncoderInterface $encoder,
        $avatarsDirectory,
        $backgroundsDirectory
    )
    {
        $this->_logger = $logger;
        $this->_entityManager = $entityManager;
        $this->_encoder = $encoder;
        $this->_avatarsDirectory = $avatarsDirectory;
        $this->_backgroundsDirectory = $backgroundsDirectory;
        $this->_userRepository = $this->_entityManager
            ->getRepository('ContactBundle:User');
    }

    public function get($id): User
    {
        $user = $this->_userRepository->findOneById($id);
        return $user;
    }

    /**
     * Method to create a user from a DTO.
     *
     * @param UserDto $user The user
     * @return void
     */
    public function createUser(User $user): void
    {
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

    public function setAvatar(UploadedFile $avatar, $user)
    {
        $user->setAvatar($user->getId() . '.' . $avatar->guessExtension());
        $avatar->move($this->_avatarsDirectory, $user->getAvatar());

        $this->_entityManager->persist($user);
        $this->_entityManager->flush();
    }

    public function setBackground(UploadedFile $background, $user)
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
