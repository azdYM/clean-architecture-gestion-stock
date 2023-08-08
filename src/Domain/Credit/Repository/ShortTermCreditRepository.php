<?php

namespace App\Domain\Credit\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Credit\Entity\ShortTermCredit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ShortTermCredit>
 *
 * @method ShortTermCredit|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortTermCredit|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortTermCredit[]    findAll()
 * @method ShortTermCredit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortTermCreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortTermCredit::class);
    }

//    /**
//     * @return ShortTermCredit[] Returns an array of ShortTermCredit objects
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

//    public function findOneBySomeField($value): ?ShortTermCredit
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
