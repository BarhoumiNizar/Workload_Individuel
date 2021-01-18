<?php

namespace App\Repository;

use App\Entity\AffectationRessources;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AffectationRessources|null find($id, $lockMode = null, $lockVersion = null)
 * @method AffectationRessources|null findOneBy(array $criteria, array $orderBy = null)
 * @method AffectationRessources[]    findAll()
 * @method AffectationRessources[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationRessourcesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AffectationRessources::class);
    }

    // /**
    //  * @return AffectationRessources[] Returns an array of AffectationRessources objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AffectationRessources
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
