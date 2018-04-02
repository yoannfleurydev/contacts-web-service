<?php

namespace Tests\ContactBundle\Assembler;

use ContactBundle\Assembler\UserAssembler;
use ContactBundle\DTO\UserDto;
use ContactBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserAssemblerTest extends TestCase
{
    public function testDtoToEntity()
    {
        $userDto = new UserDto();
        $userDto
            ->setAvatar("avatar")
            ->setBackground("background")
            ->setUsername("username")
            ->setPassword("password");

        $userAssembler = new UserAssembler("/web", "/web");
        $user = $userAssembler->dtoToEntity($userDto);

        $this->assertEquals(null, $user->getId());
        $this->assertEquals("default.jpg", $user->getAvatar());
        $this->assertEquals("default.jpg", $user->getBackground());
        $this->assertEquals("username", $user->getUsername());
        $this->assertEquals("password", $user->getPassword());
    }

    public function testEntityToDto()
    {
        $user = new User();
        $user
            ->setId("id")
            ->setAvatar("avatar")
            ->setBackground("background")
            ->setUsername("username")
            ->setPassword("password");

        $userAssembler = new UserAssembler("/web/public/uploads/avatars", "/web/public/uploads/avatars");
        $userDto = $userAssembler->entityToDto($user);

        $this->assertEquals("id", $userDto->getId());
        $this->assertEquals("/public/uploads/avatars/avatar", $userDto->getAvatar());
        $this->assertEquals("/public/uploads/avatars/background", $userDto->getBackground());
        $this->assertEquals("username", $userDto->getUsername());
    }

    public function testEntitiesToDtos()
    {
        $user1 = new User();
        $user1
            ->setId("id")
            ->setAvatar("avatar")
            ->setBackground("background")
            ->setUsername("username")
            ->setPassword("password");

        $user2 = new User();
        $user2
            ->setId("id2")
            ->setAvatar("avatar2")
            ->setBackground("background2")
            ->setUsername("username2")
            ->setPassword("password2");

        $userAssembler = new UserAssembler("/web/public/uploads/avatars", "/web/public/uploads/avatars");
        $usersDto = $userAssembler->entitiesToDtos([$user1, $user2]);

        $this->assertEquals(2, count($usersDto));
        $this->assertEquals("id", $usersDto[0]->getId());
        $this->assertEquals("/public/uploads/avatars/avatar", $usersDto[0]->getAvatar());
        $this->assertEquals("/public/uploads/avatars/background", $usersDto[0]->getBackground());
        $this->assertEquals("username", $usersDto[0]->getUsername());
    }
}
