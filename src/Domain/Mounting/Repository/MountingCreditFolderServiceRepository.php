<?php

namespace App\Domain\Mounting\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Mounting\Entity\MountingCreditFolderService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<MountingCreditFolderService>
 *
 * @method MountingCreditFolderService|null find($id, $lockMode = null, $lockVersion = null)
 * @method MountingCreditFolderService|null findOneBy(array $criteria, array $orderBy = null)
 * @method MountingCreditFolderService[]    findAll()
 * @method MountingCreditFolderService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MountingCreditFolderServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MountingCreditFolderService::class);
    }

//    /**
//     * @return MountingCreditFolderService[] Returns an array of MountingCreditFolderService objects
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

//    public function findOneBySomeField($value): ?MountingCreditFolderService
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
