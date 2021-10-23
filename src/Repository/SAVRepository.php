<?php

namespace App\Repository;

use App\Entity\SAV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SAV|null find($id, $lockMode = null, $lockVersion = null)
 * @method SAV|null findOneBy(array $criteria, array $orderBy = null)
 * @method SAV[]    findAll()
 * @method SAV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SAVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SAV::class);
    }

    public function getTodayDate():void 
    {
        $now = $this->getEntityManager();
        $query = $now->createQuery('
            SELECT * FROM `sav` 
            WHERE date = date(now()) 
            ORDER by `day_moment`
            ');
    
        $TodayDate = $query->getResult();
    }

    // /**
    //  * @return SAV[] Returns an array of SAV objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SAV
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
