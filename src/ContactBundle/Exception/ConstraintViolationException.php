<?php

namespace ContactBundle\Exception;


use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ConstraintViolationException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string     $message  The json exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = "", \Exception $previous = null, $code = 0)
    {
        parent::__construct(422, $message, $previous, [], $code);
    }

    public static function fromConstraintViolationErrorList(array $constraintViolationList, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($constraintViolationList, 'json');
        return new ConstraintViolationException($json);
    }
}
