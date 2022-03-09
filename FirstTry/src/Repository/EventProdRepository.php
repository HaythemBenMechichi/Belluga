<?php

namespace App\Repository;

use App\Entity\EventProd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventProd|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventProd|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventProd[]    findAll()
 * @method EventProd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventProdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventProd::class);
    }

    // /**
    //  * @return EventProd[] Returns an array of EventProd objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventProd
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
