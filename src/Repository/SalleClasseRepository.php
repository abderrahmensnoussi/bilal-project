<?php

namespace App\Repository;

use App\Entity\SalleClasse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalleClasse>
 *
 * @method SalleClasse|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalleClasse|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalleClasse[]    findAll()
 * @method SalleClasse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalleClasse::class);
    }

    //    /**
    //     * @return SalleClasse[] Returns an array of SalleClasse objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SalleClasse
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
