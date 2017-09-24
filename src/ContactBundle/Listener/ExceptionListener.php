<?php

namespace ContactBundle\Listener;

use ContactBundle\Exception\ConstraintViolationException;
use JMS\Serializer\Serializer;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ExceptionListener
 * 
 * @package ContactBundle\Listener
 * 
 */
class ExceptionListener
{
    /**
     * The logger to log the exception.
     * 
     * @var Logger
     */
    private $_logger;

    /**
     * The serializer to return a JSON exception.
     */
    private $_serializer;

    /*
     * Constructor of the ExceptionListener.
     *
     * @param Logger $logger The instance of the logger dependency.
     */
    public function __construct(Logger $logger, Serializer $serializer)
    {
        $this->_logger = $logger;
        $this->_serializer = $serializer;
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof HttpException) {
            // If instance of HttpException then send expected status code
            $this->_logger->addInfo(
                get_class($exception) .
                ' (' . $exception->getStatusCode() . ') : ' .
                $event->getRequest()->getRequestUri()
            );

            $event->setResponse(
                new Response(
                    $this->_serializer->serialize($exception->getMessage(), 'json'), 
                    $exception->getStatusCode(), 
                    ['Content-Type' => 'application/json']
                )
            );
        }
    }
}
