<?php

namespace App\Repository;

use App\Entity\GaleryUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GaleryUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method GaleryUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method GaleryUser[]    findAll()
 * @method GaleryUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GaleryUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GaleryUser::class);
    }

    // /**
    //  * @return GaleryUser[] Returns an array of GaleryUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GaleryUser
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
