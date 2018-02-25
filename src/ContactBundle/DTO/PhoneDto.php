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
     * @var string
     *
     * @Type("string")
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
     * @Type("int")
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
     * Set the phone number
     *
     * @param string $number The number of the phone.
     *
     * @return PhoneDto The current phone instance
     */
    public function setNumber($number): PhoneDto
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get the number of the phone
     *
     * @return string The phone number
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Set the type of the phone
     *
     * @param integer $type The type of the phone.
     *
     * @return PhoneDto The current instance.
     */
    public function setType($type): PhoneDto
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the type of the phone
     *
     * @return int The type of the phone
     */
    public function getType(): int
    {
        return $this->type;
    }
}

