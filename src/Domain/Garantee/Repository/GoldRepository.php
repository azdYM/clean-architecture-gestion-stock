<?php

namespace App\Domain\Garantee\Repository;

use App\Domain\Garantee\Entity\Gold;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Gold>
 *
 * @method Gold|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gold|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gold[]    findAll()
 * @method Gold[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gold::class);
    }

//    /**
//     * @return Gold[] Returns an array of Gold objects
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

//    public function findOneBySomeField($value): ?Gold
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
