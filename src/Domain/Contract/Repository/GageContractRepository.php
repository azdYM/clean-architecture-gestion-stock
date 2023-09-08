<?php

namespace App\Domain\Contract\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Contract\Entity\GageContract;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends AbstractRepository<GageContract>
 *
 * @method GageContract|null find($id, $lockMode = null, $lockVersion = null)
 * @method GageContract|null findOneBy(array $criteria, array $orderBy = null)
 * @method GageContract[]    findAll()
 * @method GageContract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GageContractRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GageContract::class);
    }

//    /**
//     * @return GageContract[] Returns an array of GageContract objects
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

//    public function findOneBySomeField($value): ?GageContract
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
