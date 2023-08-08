<?php

namespace App\Domain\Mounting\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Mounting\Entity\ShortTermFolder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ShortTermFolder>
 *
 * @method ShortTermFolder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortTermFolder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortTermFolder[]    findAll()
 * @method ShortTermFolder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortTermFolderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortTermFolder::class);
    }

//    /**
//     * @return ShortTermFolder[] Returns an array of ShortTermFolder objects
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

//    public function findOneBySomeField($value): ?ShortTermFolder
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
