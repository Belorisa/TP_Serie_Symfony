<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findSeriesCustom(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.popularity > :popularity')
            ->andWhere('s.vote < :vote')
            ->OrderBy('s.popularity', 'DESC')
            ->addOrderBy('s.firstAirDate', 'DESC')
            ->setParameter('popularity', 400)
            ->setParameter('vote', 8)
            ->setParameter('date', new \datetime('now'))
            ->getQuery()
            ->getResult();
    }

    public function findSeriesWithDQL(float $popularity, float $vote): array
    {
        $dql =
            'select s from app\entity\Serie s
                where (s.popularity > :popularity OR s.firstAirDate > :date) and s.vote > :vote
                order by s.popularity,s.firstAirDate DESC';
        return $this->getEntityManager()->createQuery($dql)
            ->setMaxResults(10)
            ->setFirstResult(0)
            ->setParameter('popularity', $popularity)
            ->setParameter('vote', $vote)
            ->setParameter('date', new \datetime('5 years'))
            ->execute();
    }

    //    /**
    //     * @return Serie[] Returns an array of Serie objects
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

    //    public function findOneBySomeField($value): ?Serie
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
