<?php

namespace Tests\ContactBundle\Entity;

use ContactBundle\Entity\Contact;
use ContactBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetterSetter()
    {
        $contact = new Contact();
        $contact->setFirstName("firstName");

        $user = new User();
        $user->setId("id")
            ->setAvatar("avatar")
            ->setBackground("background")
            ->setUsername("username")
            ->setPassword("password")
            ->addContacts($contact);

        $this->assertEquals("id", $user->getId());
        $this->assertEquals("avatar", $user->getAvatar());
        $this->assertEquals("background", $user->getBackground());
        $this->assertEquals("username", $user->getUsername());
        $this->assertEquals("password", $user->getPassword());
        $this->assertEquals(1, count($user->getContacts()));
        $this->assertEquals("firstName", $user->getContacts()[0]->getFirstName());
        $this->assertEquals([], $user->getRoles());
    }

    public function testWrongGetterSetter()
    {
        $contact = new Contact();
        $contact->setFirstName("firstName");

        $user = new User();
        $user->setId("wrong")
            ->setAvatar("wrong")
            ->setBackground("wrong")
            ->setUsername("wrong")
            ->setPassword("wrong");

        $this->assertNotEquals("id", $user->getId());
        $this->assertNotEquals("avatar", $user->getAvatar());
        $this->assertNotEquals("background", $user->getBackground());
        $this->assertNotEquals("username", $user->getUsername());
        $this->assertNotEquals("password", $user->getPassword());
    }

    public function testSerialize()
    {
        $contact = new Contact();
        $contact->setFirstName("firstName");

        $user = new User();
        $user->setId("id")
            ->setAvatar("avatar")
            ->setBackground("background")
            ->setUsername("username")
            ->setPassword("password")
            ->addContacts($contact);

        $this->assertEquals(
            "a:3:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";}",
            $user->serialize()
        );
    }

    public function testUnserialize()
    {
        $contact = new Contact();
        $contact->setFirstName("firstName");

        $user = new User();


        $user->unserialize("a:3:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";}");
        $this->assertEquals("id", $user->getId());
        $this->assertEquals("username", $user->getUsername());
        $this->assertEquals("password", $user->getPassword());
    }

    public function testEraseCredentials()
    {
        $user = new User();
        $user->setPassword("password");

        $user->eraseCredentials();

        $this->assertEquals(null, $user->getPassword());
    }
}
