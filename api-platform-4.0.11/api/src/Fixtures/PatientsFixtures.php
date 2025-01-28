<?php

namespace App\Fixtures;

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
            $patient->setFirstName('firstName'.$i);
            $patient->setLastName('LastName'.$i);

            $manager->persist($patient);
        }

        $manager->flush();
    }
}
