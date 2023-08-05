<?php

namespace App\Domain\Garantee\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Garantee\Entity\CollateralGaranteeItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<CollateralGaranteeItem>
 *
 * @method CollateralGaranteeItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollateralGaranteeItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollateralGaranteeItem[]    findAll()
 * @method CollateralGaranteeItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollateralGaranteeItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollateralGaranteeItem::class);
    }

//    /**
//     * @return CollateralGaranteeItem[] Returns an array of CollateralGaranteeItem objects
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

//    public function findOneBySomeField($value): ?CollateralGaranteeItem
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
