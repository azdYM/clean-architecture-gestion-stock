<?php

namespace App\Domain\Credit\Gage\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Credit\Gage\Entity\RenawalGageCredit;
use App\Infrastructure\Orm\AbstractRepository;

/**
 * @extends AbstractRepository<RenawalGageCredit>
 *
 * @method RenawalGageCredit|null find($id, $lockMode = null, $lockVersion = null)
 * @method RenawalGageCredit|null findOneBy(array $criteria, array $orderBy = null)
 * @method RenawalGageCredit[]    findAll()
 * @method RenawalGageCredit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RenawalGageCreditRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RenawalGageCredit::class);
    }

//    /**
//     * @return RenawalGageCredit[] Returns an array of RenawalGageCredit objects
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

//    public function findOneBySomeField($value): ?RenawalGageCredit
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
