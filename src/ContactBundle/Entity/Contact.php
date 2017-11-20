<?php
/**
 * File for the contact entity. This entity represents the person and is
 * connected to multiple phones, dates, emails etc.
 *
 * PHP version 7.1
 *
 * @category Contact
 * @package  ContactBundle\Entity
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */

namespace ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact entity class
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="ContactBundle\Repository\ContactRepository")
 *
 * @category Contact
 * @package  ContactBundle\Entity
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
class Contact
{
    /**
     * The identifier of the contact.
     *
     * @var int The identifier of the contact.
     *
     * @ORM\Column(name="id",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The first name of the contact.
     *
     * @var string The first name of the contact.
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * The last name of the contact.
     *
     * @var string The last name of the contact.
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * The company of the contact.
     *
     * @var string The company of the contact.
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * The URL to the website of the contact.
     *
     * @var string The URL of the website of the contact.
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * The note made by the user, for the contact.
     *
     * @var string The note made by the user, for the contact.
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * The phones of the contact.
     *
     * @var Phone[]
     *
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="contact")
     */
    private $phones;

    /**
     * The user that owns the contact.
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="contacts")
     */
    private $user;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Contact
     */
    public function setUser(User $user): Contact
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName The first name of the contact.
     *
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string The first name of the contact.
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName The last name to set for the contact.
     *
     * @return Contact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set company
     *
     * @param string $company The company to set for the contact.
     *
     * @return Contact
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set website
     *
     * @param string $website The website to set for the contact.
     *
     * @return Contact
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set note
     *
     * @param string $note The note to set for the contact.
     *
     * @return Contact
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string The note of the contact.
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Add phone to the current contact.
     *
     * @param Phone $phone The phone to add to the Contact.
     *
     * @return Contact The current contact.
     */
    public function addPhone(Phone $phone)
    {
        $this->phones[] = $phone;
        $phone->setContact($this);
    }

    /**
     * Get the phones for the current contact.
     *
     * @return Phone[] An array with phone numbers in it. 
     */
    public function getPhones()
    {
        return $this->phones;
    }
}
