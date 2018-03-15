<?php

namespace ContactBundle\DTO;

use JMS\Serializer\Annotation\Type;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserDto
 *
 * @SWG\Definition(type="object", required={"username", "password"})
 *
 * @package ContactBundle\DTO
 */
class UserDto
{
    /**
     * Unique identifier as UUID
     * @var string
     *
     * @SWG\Property()
     * @Type("string")
     */
    private $id;

    /**
     * @Type("string")
     */
    private $identifier;

    /**
     * The username of the user.
     * @var string
     *
     * @SWG\Property(example="emma.watson")
     * @Assert\NotBlank(payload={"key"="user.dto.username.not.blank"})
     * @Type("string")
     */
    private $username;

    /**
     * The password of the user.
     * @var string
     *
     * @SWG\Property(example="password")
     * @Assert\NotBlank(payload={"key"="user.dto.password.not.blank"})
     * @Type("string")
     */
    private $password;

    /**
     * The avatar of the user. A string when getting the value, a multipart when setting it.
     * @var string
     *
     * @SWG\Property()
     * @Type("string")
     */
    private $avatar;

    /**
     * The background of the user. A string when getting the value, a multipart when setting it.
     * @var string
     *
     * @SWG\Property()
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
