<?php

namespace ContactBundle\Security\User;

use ContactBundle\Security\User\WebserviceUser;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class WebserviceUserProvider implements UserProviderInterface
{

    public function loadUserByUsername($username)
    {
        // make a call to your webservice here
        $userData = "test";

        // pretend it returns an array on success, false if there is no user

        if ($userData) {
            $password = "test";

            // ...

            return new WebserviceUser($username, $password);
        }

        throw new Exception(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new Exception(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return WebserviceUser::class === $class;
    }

}
