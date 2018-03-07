<?php

namespace ContactBundle\DTO\Error;


use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationErrorDto
{
    /**
     * @var string
     *
     * @Type("string")
     */
    private $code;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $message;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $key;

    /**
     * @param ConstraintViolation $constraintViolation
     * @return ConstraintViolationErrorDto
     */
    public static function fromConstraintViolation(ConstraintViolation $constraintViolation)
    {
        $error = new ConstraintViolationErrorDto();
        $error->setCode($constraintViolation->getPropertyPath());
        $error->setMessage($constraintViolation->getMessage());

        if(isset($constraintViolation->getConstraint()->payload['key'])) {
            $error->setKey($constraintViolation->getConstraint()->payload['key']);
        }

        return $error;
    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     * @return array of ConstraintViolationError
     */
    public static function fromConstraintViolationList(ConstraintViolationListInterface $constraintViolationList)
    {
        $errors = [];
        foreach ($constraintViolationList as $violation) {
            $errors[] = static::fromConstraintViolation($violation);
        }
        return $errors;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return ConstraintViolationErrorDto
     */
    public function setCode($code): ConstraintViolationErrorDto
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param $message
     * @return ConstraintViolationErrorDto
     */
    public function setMessage($message): ConstraintViolationErrorDto
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return ConstraintViolationErrorDto
     */
    public function setKey(string $key): ConstraintViolationErrorDto
    {
        $this->key = $key;
        return $this;
    }
}
