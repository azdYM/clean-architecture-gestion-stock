<?php

namespace App\Domain\Credit\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Mounting\Entity\PawnCredit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<PawnCredit>
 *
 * @method PawnCredit|null find($id, $lockMode = null, $lockVersion = null)
 * @method PawnCredit|null findOneBy(array $criteria, array $orderBy = null)
 * @method PawnCredit[]    findAll()
 * @method PawnCredit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PawnCreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PawnCredit::class);
    }

//    /**
//     * @return PawnCredit[] Returns an array of PawnCredit objects
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

//    public function findOneBySomeField($value): ?PawnCredit
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
