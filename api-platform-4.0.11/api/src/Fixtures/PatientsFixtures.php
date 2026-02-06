<?php

namespace App\Fixtures;

use App\Entity\Address;
use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $length = 20;
        for($i=0; $i<$length; $i++)
        {
            $patient = new Patient();
            $patient->setFirstName('firstName'.$i+1);
            $patient->setLastName('LastName'.$i+1);
            $address = new Address();
            $address->setCity('cityName'.$i+1);
            $address->setAddress('addressName'.$i+1);
            $address->setCountry('fr');
            $address->setPostalCode($i+1);
            $patient->setAddress($address);
            $manager->persist($patient);
        }

        $manager->flush();
    }
}
