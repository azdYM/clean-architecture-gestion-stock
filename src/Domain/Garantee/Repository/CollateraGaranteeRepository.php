<?php

namespace App\Domain\Customer\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Garantee\Entity\CollateralGarantee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<CollateralGarantee>
 *
 * @method CollateralGarantee|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollateralGarantee|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollateralGarantee[]    findAll()
 * @method CollateralGarantee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollateralGaranteeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollateralGarantee::class);
    }

//    /**
//     * @return CollateralGarantee[] Returns an array of CollateralGarantee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CollateralGarantee
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
