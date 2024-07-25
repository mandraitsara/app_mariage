<?php

namespace App\Repository;
use App\Entity\Activity;
use App\Entity\Prestataire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proxies\__CG__\App\Entity\Prestataire as EntityPrestataire;

/**
 * @extends ServiceEntityRepository<Activity>
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

   

    //    /**
    //     * @return Activity[] Returns an array of Activity objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Activity
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
        /**
        * @return Activity[] Returns an array of Activity objects
     */
    public function activityId($user_id): ?Activity
    {

        return $this->createQueryBuilder('a')
                ->andWhere('a.id=:user_id')
                ->setParameter('user_id', $user_id)
                ->getQuery()
                ->getOneOrNullResult();
    }

    /**
     * @return Activity[] Returns an array of Activity objects
    */
    // public function find($id): ?Activity
    // {
    //     return $this->createQueryBuilder('p')
    //     ->andWhere('p.id=:id')
    //     ->setParameter('id',$id)
    //     ->getQuery()
    //     ->getOneOrNullResult();
    // }


    
    
}
