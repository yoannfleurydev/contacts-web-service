<?php

namespace ContactBundle\DTO;

use JMS\Serializer\Annotation\Type;

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
     * @Type("string")
     */
    private $username;

    /**
     * @Type("string")
     */
    private $password;


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

    public function setPlainPassword($plainPassword): UserDto
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
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
}
