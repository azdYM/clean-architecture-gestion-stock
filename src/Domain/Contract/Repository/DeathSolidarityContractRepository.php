<?php

namespace App\Domain\Contract\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Contract\Entity\DeathSolidarityContract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<DeathSolidarityContract>
 *
 * @method DeathSolidarityContract|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeathSolidarityContract|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeathSolidarityContract[]    findAll()
 * @method DeathSolidarityContract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeathSolidarityContractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeathSolidarityContract::class);
    }

//    /**
//     * @return DeathSolidarityContract[] Returns an array of DeathSolidarityContract objects
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

//    public function findOneBySomeField($value): ?DeathSolidarityContract
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
