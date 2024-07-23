<?php

namespace App\Repository;

use App\Entity\PrestataireTarif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrestataireTarif>
 */
class PrestataireTarifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrestataireTarif::class);
    }

    //    /**
    //     * @return PrestataireTarif[] Returns an array of PrestataireTarif objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

        /*
        *@return PrestataireTarif[] Returns an array of PrestataireTarif objects
        */
        public function prestateurID($prestataire_id):array
        {
            return $this->createQueryBuilder('pr')
                ->andWhere('pr.prestaId=:prestataire_id')
                ->setParameter('prestataire_id', $prestataire_id)
                ->getQuery()
                ->getResult();
        }

    //    public function findOneBySomeField($value): ?PrestataireTarif
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
