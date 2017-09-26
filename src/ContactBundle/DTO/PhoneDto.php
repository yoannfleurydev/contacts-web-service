<?php
/**
 * File for the phone DTO. This DTO represents the phone number using a number
 * and a type.
 *
 * PHP version 7.1
 *
 * @category Phone
 * @package  ContactBundle\DTO
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */

namespace ContactBundle\DTO;

use JMS\Serializer\Annotation\Type;

/**
 * Phone
 *
 * @category Phone
 * @package  ContactBundle\DTO
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
class PhoneDto
{
    /**
     * The identifier of the phone.
     *
     * @var int
     *
     * @Type("integer")
     */
    private $id;

    /**
     * The number of the phone.
     *
     * @var string
     *
     * @Type("string")
     */
    private $number;

    /**
     * The type of the phone number.
     *
     * @var int
     *
     * @Type("string")
     */
    private $type;

    public function setId($id): PhoneDto
    {
        $this->id = $id;

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

