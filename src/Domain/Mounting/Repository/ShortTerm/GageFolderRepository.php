<?php

namespace App\Domain\Mounting\Repository\ShortTerm;

use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Orm\AbstractRepository;
use App\Domain\Mounting\Entity\ShortTerm\GageFolder;

/**
 * @extends AbstractRepository<GageFolder>
 *
 * @method GageFolder|null find($id, $lockMode = null, $lockVersion = null)
 * @method GageFolder|null findOneBy(array $criteria, array $orderBy = null)
 * @method GageFolder[]    findAll()
 * @method GageFolder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GageFolderRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GageFolder::class);
    }

    public function findFolderWithAttestations($id)
    {
        $entityManager = $this->getEntityManager();

        $folder = $entityManager->createQuery(
            'SELECT f, e
            FROM App\Domain\Mounting\Entity\ShortTerm\GageFolder f
            LEFT JOIN App\Domain\Garantee\Entity\Gold\GoldAttestation e WITH e.folder = f.id
            WHERE f.id = :identifier'
        )
        ->setParameter('identifier', $id) 
        ->getResult();

        return $folder;
    }

//    /**
//     * @return GageFolder[] Returns an array of GageFolder objects
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

//    public function findOneBySomeField($value): ?GageFolder
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
