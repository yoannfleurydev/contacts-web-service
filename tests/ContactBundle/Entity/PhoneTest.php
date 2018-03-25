<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 25/03/2018
 * Time: 16:54
 */

namespace Tests\ContactBundle\Entity;

use ContactBundle\Entity\Contact;
use ContactBundle\Entity\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testGetterSetter()
    {
        $contact = new Contact();
        $contact->setFirstName("firstName");

        $phone = new Phone();
        $phone
            ->setNumber("0200112233")
            ->setType(1)
            ->setContact($contact);

        $this->assertEquals(null, $phone->getId());
        $this->assertEquals("0200112233", $phone->getNumber());
        $this->assertEquals(1, $phone->getType());
        $this->assertEquals($contact, $phone->getContact());
    }

    public function testWrongGetterSetter()
    {
        $contact = new Contact();
        $contact->setFirstName("wrong");

        $phone = new Phone();
        $phone
            ->setNumber("wrong")
            ->setType(0)
            ->setContact($contact);

        $this->assertNotEquals("0200112233", $phone->getNumber());
        $this->assertNotEquals(1, $phone->getType());
        $this->assertNotEquals(new Contact(), $phone->getContact());
    }
}
