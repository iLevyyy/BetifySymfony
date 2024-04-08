<?php

namespace App\Repository;

use App\Entity\CancionesWeekly;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CancionesWeekly>
 *
 * @method CancionesWeekly|null find($id, $lockMode = null, $lockVersion = null)
 * @method CancionesWeekly|null findOneBy(array $criteria, array $orderBy = null)
 * @method CancionesWeekly[]    findAll()
 * @method CancionesWeekly[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CancionesWeeklyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CancionesWeekly::class);
    }

//    /**
//     * @return CancionesWeekly[] Returns an array of CancionesWeekly objects
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

//    public function findOneBySomeField($value): ?CancionesWeekly
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
