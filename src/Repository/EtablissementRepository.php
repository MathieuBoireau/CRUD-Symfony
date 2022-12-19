<?php

namespace App\Repository;

use App\Entity\Etablissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etablissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etablissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etablissement[]    findAll()
 * @method Etablissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtablissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etablissement::class);
    }

    private function getFirstResult($page){
        $cpt = 0;
        while($page > 1){
            $cpt += 50;
            $page--;
        }

        return $cpt;
    }

     /**
      * @return Etablissement[] Returns an array of Etablissement objects
      */
    public function findAllLimit($page) {
        if($page < 1)
            return null;
        $firstResult = $this->getFirstResult($page);

        return $this->createQueryBuilder('etablissement')
            ->setFirstResult($firstResult)
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
      * @return Etablissement[] Returns an array of Etablissement objects
      */
      public function findByParameterLimit($page, $name_param, $value) {
        if($page < 1)
            return null;
        $firstResult = $this->getFirstResult($page);

        return $this->createQueryBuilder('etablissement')
            ->andWhere('etablissement.'.$name_param.' = :'.$name_param)
            ->setParameter($name_param, $value)
            ->setFirstResult($firstResult)
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }
}
