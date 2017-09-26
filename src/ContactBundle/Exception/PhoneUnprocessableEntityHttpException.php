<?php

namespace ContactBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PhoneUnprocessableEntityHttpException
 * 
 * @package ContactBundle\Exception
 */
class PhoneUnprocessableEntityHttpException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct(
        $message = "Phone unprocessable", 
        \Exception $previous = null, 
        $code = 2
    ) {
        parent::__construct(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $message,
            $previous,
            array(),
            $code
        );
    }
}

