<?php

namespace ContactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testAdd()
    {
        $client = static::createClient();

        $unique = uniqid();

        $client->request(
            'POST', '/register', [], [], [],
            "{\"username\": \"$unique\", \"password\": \"$unique\"}"
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
