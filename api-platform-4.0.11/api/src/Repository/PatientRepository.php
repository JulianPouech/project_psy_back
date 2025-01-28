<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            ->select(['p.id','p.firstName','p.lastName','p.phone'])
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
            ->setParameters([
                'user_id' => $userId,
                'patient_id' => $id
            ])
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
            ->select(['p.firstName', 'p.lastName', 'p.phone'])
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
        $entityManager->flush();

    }
}
