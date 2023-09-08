<?php

namespace App\Domain\Mounting\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Mounting\Entity\MountingSection;
use App\Infrastructure\Orm\AbstractRepository;

/**
 * @extends AbstractRepository<MountingSection>
 *
 * @method MountingSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method MountingSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method MountingSection[]    findAll()
 * @method MountingSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MountingSectionRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MountingSection::class);
    }

//    /**
//     * @return MountingSection[] Returns an array of MountingSection objects
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

//    public function findOneBySomeField($value): ?MountingSection
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
