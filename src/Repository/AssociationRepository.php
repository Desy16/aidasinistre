<?php

namespace App\Repository;

use App\Entity\Association;
use App\Entity\AssociationSearch;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Association|null find($id, $lockMode = null, $lockVersion = null)
 * @method Association|null findOneBy(array $criteria, array $orderBy = null)
 * @method Association[]    findAll()
 * @method Association[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssociationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Association::class);
    }

    /**
     * Permet de récuperer tout ce qui est visible
    *  
    */
    public function findAllVisibleQuery(AssociationSearch $search)
    {
        
  
        return $this->findVisibleQuery()
                    ->where('a.city LIKE :city')
                    ->setParameter('city', $search->getCity())
                    ->orderBy('a.city')
                    ->setMaxResults(2)
                    ->getQuery()
                    ->execute()
                    ;

           /*  return $this->findVisibleQuery()
                        ->getQuery(); */

    }

    private function findVisibleQuery()
    {
        # code...
        return $this->createQueryBuilder('a');
    }


    // /**
    //  * @return Association[] Returns an array of Association objects
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
    public function findOneBySomeField($value): ?Association
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
