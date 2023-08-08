<?php

namespace App\Domain\Credit\Repository\Contract;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Credit\Entity\Contract\ContractGage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ContractGage>
 *
 * @method ContractGage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractGage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractGage[]    findAll()
 * @method ContractGage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractGageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractGage::class);
    }

//    /**
//     * @return ContractGage[] Returns an array of ContractGage objects
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

//    public function findOneBySomeField($value): ?ContractGage
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
