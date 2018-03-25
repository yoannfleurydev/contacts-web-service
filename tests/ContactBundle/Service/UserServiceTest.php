<?php

namespace Tests\ContactBundle\Service;

use ContactBundle\Entity\User;
use ContactBundle\Repository\UserRepository;
use ContactBundle\Service\UserService;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserServiceTest extends TestCase
{

    public function testGet()
    {
        $userMock = new User();
        $userMock->setUsername("userName");

        $loggerMock = $this->createMock(Logger::class);
        $encoderMock = $this->createMock(UserPasswordEncoder::class);
        $validatorMock = $this->createMock(ValidatorInterface::class);
        $serializerMock = $this->createMock(Serializer::class);

        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock->method("__call")
            ->with("findOneById")
            ->will($this->returnValue($userMock));

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->method("getRepository")->will($this->returnValue($userRepositoryMock));

        $userService = new UserService(
            $loggerMock, $entityManagerMock, $encoderMock, $validatorMock,
            $serializerMock, "", "");
        $user = $userService->get("id");

        $this->assertEquals($userMock, $user);
    }

    public function testSetBackground()
    {

    }

    public function testCreateUser()
    {

    }

    public function testDeleteUser()
    {

    }

    public function testSetAvatar()
    {

    }
}
