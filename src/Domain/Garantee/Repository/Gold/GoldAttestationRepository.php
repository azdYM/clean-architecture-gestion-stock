<?php

namespace App\Domain\Garantee\Repository\Gold;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class GoldAttestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoldAttestation::class);
    }

    public function findGoldSupervisors(): array
    {
        return [];
    }

    public function findGoldEvaluators(): array
    {
        return [];
    }

//    /**
//     * @return Employee[] Returns an array of Employee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employee
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}