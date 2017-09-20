<?php
/**
 * File for the contact DTO. This DTO represents the person and is connected to
 * multiple phones, dates, emails etc.
 * 
 * PHP version 7.1
 * 
 * @category Contact
 * @package  ContactBundle\DTO
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
namespace ContactBundle\DTO;

use JMS\Serializer\Annotation\Type;

/**
 * Contact DTO. This DTO represents the person and is connected to
 * multiple phones, dates, emails etc.
 * 
 * @category Contact
 * @package  ContactBundle\DTO
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
class ContactDto
{
    /**
     * The identifier of the contact.
     * 
     * @var int The identifier of the contact.
     *
     * @Type("integer")
     */
    private $_id;

    /**
     * The first name of the contact.
     * 
     * @var string The first name of the contact.
     *
     * @Type("string")
     */
    private $_firstName;

    /**
     * The last name of the contact.
     * 
     * @var string The last name of the contact.
     *
     * @Type("string")
     */
    private $_lastName;

    /**
     * The company of the contact.
     * 
     * @var string The company of the contact.
     * 
     * @Type("string")
     */
    private $_company;

    /**
     * The URL to the website of the contact.
     * 
     * @var string The URL of the website of the contact.
     * 
     * @Type("string")
     */
    private $_website;

    /**
     * The note made by the user, for the contact.
     * 
     * @var string The note made by the user, for the contact.
     * 
     * @Type("string")
     */
    private $_note;

    /**
     * The phones of the contact.
     *
     * @var Phone[] The phone numbers of the contact.
     * 
     * @Type("ArrayCollection<PhoneDto>")
     */
    private $_phones;

    public function setId($id): ContactDto
    {
        $this->_id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setFirstName($firstName): ContactDto
    {
        $this->_firstName = $firstName;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->_firstName;
    }

    public function setLastName($lastName): ContactDto
    {
        $this->_lastName = $lastName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->_lastName;
    }

    public function setCompany($company): ContactDto
    {
        $this->_company = $company;

        return $this;
    }

    public function getCompany(): ?string 
    {
        return $this->_company;
    }

    public function setWebsite($website): ContactDto
    {
        $this->_website = $website;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->_website;
    }

    public function setNote($note): ContactDto
    {
        $this->_note = $note;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->_note;
    }
}
