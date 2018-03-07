<?php

namespace ContactBundle\DTO;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    /**
     * @Type("string")
     */
    private $id;

    /**
     * @Type("string")
     */
    private $identifier;

    /**
     * @Assert\NotBlank(payload={"key"="user.dto.username.not.blank"})
     * @Type("string")
     */
    private $username;

    /**
     * @Assert\NotBlank(payload={"key"="user.dto.password.not.blank"})
     * @Type("string")
     */
    private $password;

    /**
     * @Type("string")
     */
    private $avatar;

    /**
     * @Type("string")
     */
    private $background;

    public function setId($id): UserDto
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIdentifier($identifier): UserDto
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setUsername($username): UserDto
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setPassword($password): UserDto
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setAvatar($avatar): UserDto
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setBackground($background): UserDto
    {
        $this->background = $background;

        return $this;
    }

    public function getBackground(): string
    {
        return $this->background;
    }
}
