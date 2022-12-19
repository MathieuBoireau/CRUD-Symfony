<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etablissement;
use DateTime;

class EtablissementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        gc_enable();
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
        $csv = fopen("./data/fr-en-adresse-et-geolocalisation-etablissements-premier-et-second-degre.csv", "r");
        $i = 0;
        while(!feof($csv)) {
            $line = fgetcsv($csv, 0, ";");
            if(!is_array($line) || count($line) < 1)
                continue;
            if($i > 0) {
                $etablissement = new Etablissement();
                $etablissement->setNom($line[1]);
                $etablissement->setNature($line[2]);
                $etablissement->setSecteur($line[4]);
                $etablissement->setLatitude((float)$line[14]);
                $etablissement->setLongitude((float)$line[15]);
                $etablissement->setAdresse($line[5]);
                $etablissement->setCommune($line[10]);
                $etablissement->setDepartement($line[26]);
                $etablissement->setRegion($line[27]);
                $etablissement->setAcademie($line[28]);
                $etablissement->setDateOuverture(DateTime::createFromFormat("Y-m-d", $line[34]));
                $manager->persist($etablissement);
                if($i % 1000 == 0) {
                    $manager->flush();
                    $manager->clear();
                    gc_collect_cycles();
                    break;
                }
            }
            $i = $i + 1;
        }
        $manager->flush();
        $manager->clear();
        gc_collect_cycles();
                    
    }
}
