<?php

namespace App\Domain\Contract\Components;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Contract\Components\GeneralContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<GeneralContent>
 *
 * @method GeneralContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneralContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneralContent[]    findAll()
 * @method GeneralContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeneralContent::class);
    }

//    /**
//     * @return GeneralContent[] Returns an array of GeneralContent objects
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

//    public function findOneBySomeField($value): ?GeneralContent
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
