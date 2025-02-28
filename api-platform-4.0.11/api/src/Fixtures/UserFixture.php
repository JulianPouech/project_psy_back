<?php

namespace App\Fixtures;

use App\Entity\Address;
use App\Entity\Patient;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher) {
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('gerald@example.wip');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'test'));
        $address = new Address();
        $address->setPostalCode('codePostal1');
        $address->setCountry('');
        $address->setAddress('addressName1');
        $address->setCity('cityName1');
        $firstNames = ['Gerald','Ivo','Maria'];
        foreach($firstNames as $firstName)
        {
            $patient = new Patient();
            $patient->setLastName('robotnik');
            $patient->setFirstName($firstName);
            $patient->setAddress($address);
            $user->addPatient($patient);
            $manager->persist($patient);
        }

        $manager->persist($user);

        $user = new User();
        $user->setEmail('admin@example.wip');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'pwd'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }

}
