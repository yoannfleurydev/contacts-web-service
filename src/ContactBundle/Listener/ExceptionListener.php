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
    protected $logger;
    
    /**
     * Constructor of the ExceptionListener.
     *
     * @param Logger $logger The instance of the logger dependency.
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof HttpException) {
            // If instance of HttpException then send expected status code
            $this->logger->addInfo(
                get_class($exception) .
                ' (' . $exception->getStatusCode() . ') : ' .
                $event->getRequest()->getRequestUri()
            );
            $event->setResponse(
                new Response(
                    '', 
                    $exception->getStatusCode(), 
                    ['Content-Type' => 'application/json']
                )
            );
        }
    }
}
