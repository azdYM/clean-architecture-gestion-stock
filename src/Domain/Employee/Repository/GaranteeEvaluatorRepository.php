<?php

namespace App\Domain\GaranteeEvaluator\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Employee\Entity\GaranteeEvaluator;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<GaranteeEvaluator>
* @implements PasswordUpgraderInterface<GaranteeEvaluator>
 *
 * @method GaranteeEvaluator|null find($id, $lockMode = null, $lockVersion = null)
 * @method GaranteeEvaluator|null findOneBy(array $criteria, array $orderBy = null)
 * @method GaranteeEvaluator[]    findAll()
 * @method GaranteeEvaluator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GaranteeEvaluatorRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GaranteeEvaluator::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof GaranteeEvaluator) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return GaranteeEvaluator[] Returns an array of GaranteeEvaluator objects
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

//    public function findOneBySomeField($value): ?GaranteeEvaluator
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
