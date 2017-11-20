<?php

namespace AppBundle\DataFixtures\ORM;

use ContactBundle\Entity\Contact;
use ContactBundle\Entity\Phone;
use ContactBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $file = file_get_contents(__DIR__."/contacts.json");
        $persons = json_decode($file, true);

        $user = new User();
        $user->setUsername("test");

        $encoder = $this->container->get("security.password_encoder");
        $password = $encoder->encodePassword($user, "test");
        $user->setPassword($password);

        $manager->persist($user);

        foreach ($persons as $key=>$person) {

            $contact = new Contact();
            $contact->setFirstName($person["firstname"]);
            $contact->setLastName($person["name"]);
            $contact->setCompany($person["company"]);
            $contact->setWebsite("www.".strtolower($person["company"]).".com");
            $contact->setNote($person["about"]);
            $contact->setUser($user);

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
