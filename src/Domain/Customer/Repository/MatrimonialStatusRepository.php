<?php

namespace App\Domain\Customer\Repository;

use App\Domain\Customer\Entity\MatrimonialStatus;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<MatrimonialStatus>
 *
 * @method MatrimonialStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatrimonialStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatrimonialStatus[]    findAll()
 * @method MatrimonialStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatrimonialStatusRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatrimonialStatus::class);
    }

//    /**
//     * @return MatrimonialStatus[] Returns an array of MatrimonialStatus objects
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

//    public function findOneBySomeField($value): ?MatrimonialStatus
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
