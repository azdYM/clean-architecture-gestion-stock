<?php

namespace App\Domain\Garantee\Repository\Gold;

use App\Domain\Garantee\Entity\Gold\Gold;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends AbstractRepository<GoldRepository>
 *
 * @method GoldRepository|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoldRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoldRepository[]    findAll()
 * @method GoldRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gold::class);
    }

//    /**
//     * @return Employee[] Returns an array of Employee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employee
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}