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
use Swagger\Annotations as SWG;

/**
 * Contact DTO. This DTO represents the person and is connected to
 * multiple phones, dates, emails etc.
 *
 * @SWG\Definition(type="object")
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
     * @var string The identifier of the contact.
     *
     * @SWG\Property()
     * @Type("string")
     */
    private $id;

    /**
     * The first name of the contact.
     *
     * @var string The first name of the contact.
     *
     * @SWG\Property()
     * @Type("string")
     */
    private $firstName;

    /**
     * The last name of the contact.
     *
     * @var string The last name of the contact.
     *
     * @SWG\Property()
     * @Type("string")
     */
    private $lastName;

    /**
     * The company of the contact.
     *
     * @var string The company of the contact.
     *
     * @SWG\Property()
     * @Type("string")
     */
    private $company;

    /**
     * The URL to the website of the contact.
     *
     * @var string The URL of the website of the contact.
     *
     * @SWG\Property()
     * @Type("string")
     */
    private $website;

    /**
     * The note made by the user, for the contact.
     *
     * @var string The note made by the user, for the contact.
     *
     * @SWG\Property()
     * @Type("string")
     */
    private $note;

    /**
     * The phones of the contact.
     *
     * @var PhoneDto[] The phone numbers of the contact.
     *
     * @SWG\Property()
     * @Type("array<ContactBundle\DTO\PhoneDto>")
     */
    private $phones;

    public function setId($id): ContactDto
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFirstName($firstName): ContactDto
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setLastName($lastName): ContactDto
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setCompany($company): ContactDto
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setWebsite($website): ContactDto
    {
        $this->website = $website;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setNote($note): ContactDto
    {
        $this->note = $note;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setPhones($phones): ContactDto
    {
        $this->phones = $phones;

        return $this;
    }

    public function getPhones()
    {
        return $this->phones;
    }
}
