<?php

namespace AppBundle\DataFixtures\ORM;

use ContactBundle\Entity\Contact;
use ContactBundle\Entity\Phone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $file = file_get_contents(__DIR__."/contacts.json");
        $persons = json_decode($file, true);

        foreach ($persons as $key=>$person) {

            $contact = new Contact();
            $contact->setFirstName($person["firstname"]);
            $contact->setLastName($person["name"]);
            $contact->setCompany($person["company"]);
            $contact->setWebsite("www.".strtolower($person["company"]).".com");
            $contact->setNote($person["about"]);

            $manager->persist($contact);

            $phone = new Phone();
            $phone->setContact($contact);
            $phone->setNumber($person["phone"]);
            $phone->setType($person["phoneType"]);

            $manager->persist($phone);
        }

        $manager->flush();
    }
}
