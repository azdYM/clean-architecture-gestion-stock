<?php

namespace App\Domain\Customer\Repository;

use App\Domain\Customer\Entity\Corporate;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Corporate>
 *
 * @method Corporate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Corporate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Corporate[]    findAll()
 * @method Corporate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CorporateRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Corporate::class);
    }

    public function findCorporateByFolio(int $folio)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.folio = :folio')
            ->setParameter('folio', $folio)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Corporate[] Returns an array of Corporate objects
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

//    public function findOneBySomeField($value): ?Corporate
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
