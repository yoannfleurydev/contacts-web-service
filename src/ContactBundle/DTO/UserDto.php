<?php

namespace ContactBundle\DTO;

use JMS\Serializer\Annotation\Type;

class UserDto
{
    /**
     * @Type("integer")
     */
    private $id;

    /**
     * @Type("string")
     */
    private $username;

    /**
     * @Type("string")
     */
    private $plainPassword;

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
