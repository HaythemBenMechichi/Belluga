<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    function orderByDateDescQB(){
        return $this->createQueryBuilder('ev')
            -> orderBy('ev.DateDebut','DESC')
            -> getQuery()->getResult();
    }

    function orderByDateAscQB(){
        return $this->createQueryBuilder('ev')
            -> orderBy('ev.DateDebut','ASC')
            -> getQuery()->getResult();
    }

    function orderByNameAscQB(){
        return $this->createQueryBuilder('ev')
            -> orderBy('ev.nom','ASC')
            -> getQuery()->getResult();
    }

    function orderByNameDescQB(){
        return $this->createQueryBuilder('ev')
            -> orderBy('ev.nom','DESC')
            -> getQuery()->getResult();
    }

    public function findEventByName($nom){
        return $this->createQueryBuilder('event')
            ->where('event.nom LIKE :nom')
            ->setParameter('nom', '%'.$nom.'%')
            ->getQuery()->getResult();
    }

    // /**
    //  * @return Evenement[] Returns an array of Evenement objects
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
    public function findOneBySomeField($value): ?Evenement
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
