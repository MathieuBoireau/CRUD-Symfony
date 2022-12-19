<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    // /**
    //  * @return Commentaire[] Returns an array of Commentaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commentaire
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    private function getFirstResult($page){
        $cpt = 0;
        while($page > 1){
            $cpt += 50;
            $page--;
        }
        
        return $cpt;
    }
    
    /**
    * @return Commentaire[] Returns an array of Commentaire objects
    */
    public function findByEtablissementLimit($page, $value) {
        if($page < 1)
            return null;
        $firstResult = $this->getFirstResult($page);
        
        return $this->createQueryBuilder('commentaire')
        ->andWhere('commentaire.etablissement = :etablissement')
        ->setParameter('etablissement', $value)
        ->setFirstResult($firstResult)
        ->setMaxResults(50)
        ->getQuery()
        ->getResult()
        ;
    }
}
    