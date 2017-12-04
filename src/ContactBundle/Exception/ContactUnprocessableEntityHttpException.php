<?php

namespace ContactBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactUnprocessableEntityHttpException
 *
 * @package ContactBundle\Exception
 */
class ContactUnprocessableEntityHttpException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct(
        $message = "Contact unprocessable",
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

