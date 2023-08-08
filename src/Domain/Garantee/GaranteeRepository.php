<?php

namespace App\Domain\Customer\Repository;

use App\Domain\Garantee\Garantee;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Garantee>
 *
 * @method Garantee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Garantee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Garantee[]    findAll()
 * @method Garantee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GaranteeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Garantee::class);
    }

//    /**
//     * @return Garantee[] Returns an array of Garantee objects
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

//    public function findOneBySomeField($value): ?Garantee
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
