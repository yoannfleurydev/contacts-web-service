<?php

namespace ContactBundle\EventListener;

use ContactBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $em
     */
    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        // Get username from jwtToken
        $username = $payload["username"];

        $user = $this->em->getRepository(User::class)
            ->loadUserByUsername($username);

        // Add uuid user in jwtToken
        $payload["uuid"] = $user->getId();

        $event->setData($payload);
    }

}
