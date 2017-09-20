<?php
/**
 * File for the phone entity. This entity represents the phone number using
 * a number and a type.
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
 * Phone
 *
 * @ORM\Table(name="phone")
 * @ORM\Entity(repositoryClass="ContactBundle\Repository\PhoneRepository")
 * 
 * @category Contact
 * @package  ContactBundle\Entity
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
class Phone
{
    /**
     * The identifier of the phone.
     * 
     * @var int
     *
     * @ORM\Column(name="id",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $_id;

    /**
     * The number of the phone.
     * 
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255, nullable=true, unique=true)
     */
    private $_number;

    /**
     * The type of the phone number.
     * 
     * @var int
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $_type;

    /**
     * The contact that owns the phone number.
     *
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="_phones")
     */
    private $_contact;

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
     * Set number
     *
     * @param string $number The number of the phone.
     *
     * @return Phone
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set type
     *
     * @param integer $type The type of the phone.
     *
     * @return Phone
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}

