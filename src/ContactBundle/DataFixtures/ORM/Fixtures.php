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

        $user1 = new User();
        $user1->setUsername("user1");
        $user2 = new User();
        $user2->setUsername("user2");

        $encoder = $this->container->get("security.password_encoder");
        $password = $encoder->encodePassword($user1, "pass");
        $user1->setPassword($password);
        $user2->setPassword($password);

        $manager->persist($user1);
        $manager->persist($user2);

        foreach ($persons as $key=>$person) {

            $contact = new Contact();
            $contact->setFirstName($person["firstname"]);
            $contact->setLastName($person["name"]);
            $contact->setCompany($person["company"]);
            $contact->setWebsite("www.".strtolower($person["company"]).".com");
            $contact->setNote($person["about"]);

            $random = rand(1, 2);
            $random === 1 ? $contact->setUser($user1) : $contact->setUser($user2);

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
