<?php

namespace App\Domain\Garantee\Repository\Gold;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Infrastructure\Orm\AbstractRepository;

/**
 * @extends AbstractRepository<GoldAttestationRepository>
 *
 * @method GoldAttestationRepository|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoldAttestationRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoldAttestationRepository[]    findAll()
 * @method GoldAttestationRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoldAttestationRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoldAttestation::class);
    }

    public function findGoldSupervisors(): array
    {
        return [];
    }

    public function findGoldEvaluators(): array
    {
        return [];
    }

//    /**
//     * @return Employee[] Returns an array of Employee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employee
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}