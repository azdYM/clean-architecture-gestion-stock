<?php

namespace App\Domain\Contract\Components;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Contract\Components\ParameterInDescription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ParameterInDescription>
 *
 * @method ParameterInDescription|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParameterInDescription|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParameterInDescription[]    findAll()
 * @method ParameterInDescription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParameterInDescriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParameterInDescription::class);
    }

//    /**
//     * @return ParameterInDescription[] Returns an array of ParameterInDescription objects
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

//    public function findOneBySomeField($value): ?ParameterInDescription
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
