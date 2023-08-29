<?php

namespace App\Domain\Contract\Components;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Contract\Components\SignatureLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<SignatureLabel>
 *
 * @method SignatureLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method SignatureLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method SignatureLabel[]    findAll()
 * @method SignatureLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignatureLabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignatureLabel::class);
    }

//    /**
//     * @return SignatureLabel[] Returns an array of SignatureLabel objects
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

//    public function findOneBySomeField($value): ?SignatureLabel
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
