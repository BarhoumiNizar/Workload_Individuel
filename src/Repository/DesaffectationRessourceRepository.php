<?php

namespace App\Repository;

use App\Entity\DesaffectationRessource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DesaffectationRessource|null find($id, $lockMode = null, $lockVersion = null)
 * @method DesaffectationRessource|null findOneBy(array $criteria, array $orderBy = null)
 * @method DesaffectationRessource[]    findAll()
 * @method DesaffectationRessource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DesaffectationRessourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DesaffectationRessource::class);
    }

    // /**
    //  * @return DesaffectationRessource[] Returns an array of DesaffectationRessource objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DesaffectationRessource
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
