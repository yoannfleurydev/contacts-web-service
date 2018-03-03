<?php

namespace ContactBundle\Tests\DTO;


use ContactBundle\DTO\UserDto;
use PHPUnit\Framework\TestCase;

class UserDtoTest extends TestCase
{
    public function testGetterSetter()
    {
        $userDto = new UserDto();
        $userDto->setId("id")
            ->setAvatar("avatar")
            ->setBackground("background")
            ->setUsername("username")
            ->setPassword("password");

        $this->assertEquals("id", $userDto->getId());
        $this->assertEquals("avatar", $userDto->getAvatar());
        $this->assertEquals("background", $userDto->getBackground());
        $this->assertEquals("username", $userDto->getUsername());
        $this->assertEquals("password", $userDto->getPassword());
    }

    public function testWrongGetterSetter()
    {
        $userDto = new UserDto();
        $userDto->setId("wrong")
            ->setAvatar("wrong")
            ->setBackground("wrong")
            ->setUsername("wrong")
            ->setPassword("wrong");

        $this->assertNotEquals("id", $userDto->getId());
        $this->assertNotEquals("avatar", $userDto->getAvatar());
        $this->assertNotEquals("background", $userDto->getBackground());
        $this->assertNotEquals("username", $userDto->getUsername());
        $this->assertNotEquals("password", $userDto->getPassword());
    }
}
