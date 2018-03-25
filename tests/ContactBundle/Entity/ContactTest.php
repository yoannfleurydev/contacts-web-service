<?php

namespace Tests\ContactBundle\Entity;

use ContactBundle\Entity\Contact;
use ContactBundle\Entity\Phone;
use ContactBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testGetterSetter()
    {
        $user = new User();
        $user->setUsername("userName");

        $phone = new Phone();
        $phone
            ->setType("type")
            ->setNumber("0200112233");

        $contact = new Contact();
        $contact
            ->setCompany("company")
            ->setFirstName("firstName")
            ->setLastName("lastName")
            ->setNote("note")
            ->setWebsite("website")
            ->setPhones([$phone])
            ->setUser($user);

        $this->assertEquals(null, $contact->getId());
        $this->assertEquals("company", $contact->getCompany());
        $this->assertEquals("firstName", $contact->getFirstName());
        $this->assertEquals("lastName", $contact->getLastName());
        $this->assertEquals("note", $contact->getNote());
        $this->assertEquals("website", $contact->getWebsite());
        $this->assertEquals([$phone], $contact->getPhones());
        $this->assertEquals($user, $contact->getUser());
    }

    public function testAddPhone()
    {
        $phone = new Phone();
        $phone
            ->setType("type")
            ->setNumber("0200112233");

        $contact = new Contact();
        $contact
            ->addPhone($phone);

        $this->assertEquals([$phone], $contact->getPhones());
    }

    public function testWrongGetterSetter()
    {
        $user = new User();
        $user->setUsername("wrong");

        $phone = new Phone();
        $phone
            ->setType("type")
            ->setNumber("0200112233");

        $contact = new Contact();
        $contact
            ->setCompany("wrong")
            ->setFirstName("wrong")
            ->setLastName("wrong")
            ->setNote("wrong")
            ->setWebsite("wrong")
            ->setPhones([])
            ->setUser(new User());

        $this->assertNotEquals("id", $contact->getId());
        $this->assertNotEquals("company", $contact->getCompany());
        $this->assertNotEquals("firstName", $contact->getFirstName());
        $this->assertNotEquals("lastName", $contact->getLastName());
        $this->assertNotEquals("note", $contact->getNote());
        $this->assertNotEquals("website", $contact->getWebsite());
        $this->assertNotEquals([$phone], $contact->getPhones());
        $this->assertNotEquals($user, $contact->getUser());
    }
}
