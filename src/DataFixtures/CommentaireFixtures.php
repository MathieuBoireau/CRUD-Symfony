<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etablissement;
use App\Entity\Commentaire;
use DateTime;

class CommentaireFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $csv = fopen("./data/commentaires.csv", "r");
        $i = 0;
        while(!feof($csv)) {
            $line = fgetcsv($csv, 0, ";");
            if(!is_array($line) || count($line) < 1)
                continue;
            if($i > 0) {
                $commentaire = new Commentaire();
                $commentaire->setNomAuteur($line[0]);
                $commentaire->setDate(DateTime::createFromFormat("Y-m-d", $line[1]));
                $commentaire->setNote($line[2]);
                $commentaire->setTexte($line[3]);
                //$commentaire->setEtablissement($manager->getRepository(Etablissement::class)->find(['id' => $line[4]]));
                // $etablissement = $manager->getRepository(Etablissement::class)->find((int)$line[4]);
                $etablissement = $manager->getRepository(Etablissement::class)->findOneBy(["id" =>$line[4]]);
                echo $etablissement->getNom();
                if($etablissement) $commentaire->setEtablissement($etablissement);
                
                $manager->persist($commentaire);
                if($i % 100 == 0) {
                    $manager->flush();
                }
            }
            $i = $i + 1;
        }
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 22;
    }
}
    