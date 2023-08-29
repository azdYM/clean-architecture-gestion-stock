<?php

namespace App\Domain\Garantee\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Garantee\Entity\EvaluationGageService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<EvaluationGageService>
 *
 * @method EvaluationGageService|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvaluationGageService|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvaluationGageService[]    findAll()
 * @method EvaluationGageService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationGageServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluationGageService::class);
    }

//    /**
//     * @return EvaluationGageService[] Returns an array of EvaluationGageService objects
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

//    public function findOneBySomeField($value): ?EvaluationGageService
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
