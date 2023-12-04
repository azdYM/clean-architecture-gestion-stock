<?php

namespace App\Domain\Credit\Repository;

use App\Domain\Credit\Entity\CreditType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<CreditType>
 *
 * @method CreditType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditType[]    findAll()
 * @method CreditType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditType::class);
    }

//    /**
//     * @return CreditType[] Returns an array of CreditType objects
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

//    public function findOneBySomeField($value): ?CreditType
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
