<?php

namespace App\Domain\Mounting\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Mounting\Entity\GageFolder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<GageFolder>
 *
 * @method GageFolder|null find($id, $lockMode = null, $lockVersion = null)
 * @method GageFolder|null findOneBy(array $criteria, array $orderBy = null)
 * @method GageFolder[]    findAll()
 * @method GageFolder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GageFolderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GageFolder::class);
    }

//    /**
//     * @return GageFolder[] Returns an array of GageFolder objects
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

//    public function findOneBySomeField($value): ?GageFolder
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
