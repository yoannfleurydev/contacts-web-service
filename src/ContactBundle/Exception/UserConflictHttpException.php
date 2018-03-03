<?php

namespace ContactBundle\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class UserConflictHttpException
 *
 * @package ContactBundle\Exception
 * @author  Yoann Fleury <yoann.fleury@yahoo.com>
 */
class UserConflictHttpException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct(
        $message = "User already exists",
        \Exception $previous = null,
        $code = 1
    ) {
        parent::__construct(
            Response::HTTP_CONFLICT,
            $message,
            $previous,
            array(),
            $code
        );
    }
}
