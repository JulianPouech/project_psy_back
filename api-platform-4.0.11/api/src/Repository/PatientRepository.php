<?php

namespace App\Repository;

use App\Entity\Address;
use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Patient>
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Patient::class);
    }

    public function getAll(int $pages = 0): array {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.address','a')
            ->select(['p.id','p.firstName','p.lastName','p.phone','a.address'])
            ->setMaxResults(20)
            ->setFirstResult($pages*20)
            ->getQuery()
            ->getResult();
    }

    public function findByUserId(int $userId, int $id): mixed {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->where('u.id = :user_id')
            ->andWhere('p.id = :patient_id')
            ->setParameters(new ArrayCollection([
                new Parameter('user_id',$userId),
                new Parameter('patient_id',$id),
            ]))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param array<int,mixed> $filter
     */
    public function findByFilter(array $filter): mixed {
        $lastName = $filter['lastName']??'';
        $firstName = $filter['firstName']??'';

        return $this->createQueryBuilder('p')
            ->select(['p.id', 'p.firstName', 'p.lastName', 'p.phone', 'p.address'])
            ->where('p.firstName LIKE :firstName')
            ->andWhere('p.lastName LIKE :lastName')
            ->setParameter('lastName', '%'.$lastName.'%')
            ->setParameter('firstName', '%'.$firstName.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function update(Patient $patient): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($patient);

        if ($patient->getAddress() instanceof Address) {
            $entityManager->persist($patient->getAddress());
        }

        $entityManager->flush();

    }
}
