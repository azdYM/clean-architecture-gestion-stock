<?php

namespace App\Domain\Credit\Repository\ShortTerm;

use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Orm\AbstractRepository;
use App\Domain\Credit\Entity\ShortTerm\GageCredit;

/**
 * @extends AbstractRepository<GageCredit>
 *
 * @method GageCredit|null find($id, $lockMode = null, $lockVersion = null)
 * @method GageCredit|null findOneBy(array $criteria, array $orderBy = null)
 * @method GageCredit[]    findAll()
 * @method GageCredit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GageCreditRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GageCredit::class);
    }

//    /**
//     * @return GageCredit[] Returns an array of GageCredit objects
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

//    public function findOneBySomeField($value): ?GageCredit
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
