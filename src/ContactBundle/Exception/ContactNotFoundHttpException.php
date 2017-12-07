<?php

namespace ContactBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactNotFoundException
 *
 * @package ContactBundle\Exception
 */
class ContactNotFoundHttpException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct(
        $message = "Contact not found",
        \Exception $previous = null,
        $code = 1
    ) {
        parent::__construct(
            Response::HTTP_NOT_FOUND,
            $message,
            $previous,
            array(),
            $code
        );
    }
}
