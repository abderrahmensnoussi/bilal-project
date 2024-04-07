<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * @return Session[]
     */
    public function findSessionBy(array $fields): array
    {
        $builder = $this->createQueryBuilder('s');
        if ($fields['formateur'] !== '') {
            $builder->leftJoin('s.formateur', 'formateur')
                ->andWhere('formateur.id = :formateur')
                ->setParameter('formateur', $fields['formateur']);
        }
        if ($fields['promotion'] !== '') {
            $builder->leftJoin('s.promotion', 'promotion')
                ->andWhere('promotion = :promotion')
                ->setParameter('promotion', $fields['promotion']);
        }
        if ($fields['eleve'] !== '') {
            if ($fields['promotion'] === '') {
                $builder->leftJoin('s.promotion', 'promotion');
            }
            $builder->leftJoin('promotion.inscriptions', 'inscription')
            ->andWhere('inscription.eleve = :eleve_id')
            ->setParameter('eleve_id', $fields['eleve']);
        }
        if (isset($fields['dateDebut']) === true) {
            $builder->andWhere('s.dateSession >= :start_date')
                ->setParameter('start_date', $fields['dateDebut']);
        }
        if (isset($fields['dateFin']) === true) {
            $builder->andWhere('s.dateSession <= :end_date')
                ->setParameter('end_date', $fields['dateFin']);
        }

        $builder->orderBy('CONCAT(s.dateSession, s.heureDebut)', 'ASC');

        return $builder->getQuery()->getResult();
    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
