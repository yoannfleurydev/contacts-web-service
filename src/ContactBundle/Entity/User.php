<?php

namespace ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ContactBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * Unique identifier of the user.
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * The username of the user.
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * The BCrypt crypted password.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * Contacts of the user.
     *
     * @var Contact[]
     *
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="user")
     */
    private $contacts;

    /**
     * Avatar of the user.
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $avatar = "default.jpg";

    /**
     * Background of the user. It could be the favorite image of the user, or
     * just the image of his choice.
     *
     * @var string Location of the background image.
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $background = "default.jpg";

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param Contact $contacts
     */
    public function addContacts(Contact $contacts)
    {
        $this->contacts[] = $contacts;
        $contacts->setUser($this);
    }

    /**
     * Get the avatar of the user
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the avatar of the user.
     *
     * @param string $avatar The location of the avatar
     *
     * @return User return the user for fluent setters
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the background of the user.
     *
     * @return string The background of the user.
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set the background of the user.
     *
     * @param string $background the image to set.
     *
     * @return User the user for fluent setters.
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO : Modif
        return [];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
