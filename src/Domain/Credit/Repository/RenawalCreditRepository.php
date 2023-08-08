<?php

namespace App\Domain\Credit\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Credit\Entity\RenawalCredit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<RenawalCredit>
 *
 * @method RenawalCredit|null find($id, $lockMode = null, $lockVersion = null)
 * @method RenawalCredit|null findOneBy(array $criteria, array $orderBy = null)
 * @method RenawalCredit[]    findAll()
 * @method RenawalCredit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RenawalCreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RenawalCredit::class);
    }

//    /**
//     * @return RenawalCredit[] Returns an array of RenawalCredit objects
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

//    public function findOneBySomeField($value): ?RenawalCredit
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
