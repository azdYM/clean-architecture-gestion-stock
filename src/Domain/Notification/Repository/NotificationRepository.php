<?php

namespace App\Domain\Notification\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Orm\AbstractRepository;
use App\Domain\Notification\Entity\Notification;

/**
 * @extends AbstractRepository<Notification>
 *
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * Persiste une nouvelle notification ou met à jour une notification précédente.
     */
    public function persistOrUpdate(Notification $notification): Notification
    {
        if (null === $notification->getUser()) {
            $this->getEntityManager()->persist($notification);

            return $notification;
        }

        $oldNotification = $this->findOneBy([
            'user' => $notification->getUser(),
            'target' => $notification->getTarget(),
        ]);
        
        if ($oldNotification) {
            $oldNotification->setCreatedAt($notification->getCreatedAt());
            $oldNotification->setMessage($notification->getMessage());

            return $oldNotification;
        } else {
            $this->getEntityManager()->persist($notification);

            return $notification;
        }
    }

//    /**
//     * @return Notification[] Returns an array of Notification objects
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

//    public function findOneBySomeField($value): ?Notification
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
