<?php

namespace App\Controller;

use App\Entity\Etablissement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EtablissementType;

class EtablissementController extends AbstractController
{
	/**
     * @Route("/etablissements", name="accueil")
     */
    public function accueil(): Response {
		return $this->render('etablissement/accueil.html.twig', [
			'titre' => "Etablissements - Accueil",
        ]);
	}

    /**
     * @Route("/etablissements/all", name="get_etablissements")
     */
    public function getEtablissements(): Response
    {
		$page = $_GET["page"];
		$repository = $this->getDoctrine()->getRepository(Etablissement::class);
		$etablissements = $repository->findAllLimit($page);

		$lienPrecedent = "";
		$lienSuivant = "";
		$lienPremier = "";
		$url = "http://localhost:8000/etablissements/all?page=";
		if(!empty($repository->findAllLimit($page-1)))
			$lienPrecedent = $url.($page-1);
		if(!empty($repository->findAllLimit($page+1)))
			$lienSuivant = $url.($page+1);
		
		if($page != 1)
			$lienPremier = $url."1";
		
		return $this->render('etablissement/affichageTable.html.twig', [
			'titre' => "Etablissements",
			'etablissements' => $etablissements,
			'lienPrecedent' => $lienPrecedent,
			'lienSuivant' => $lienSuivant,
			'lienPremier' => $lienPremier
        ]);
	}

	/**
     * @Route("/etablissements/id/{id}", name="get_etablissements_id", defaults={"id" = "1"})
     */
    public function getEtablissementsId(int $id): Response {
		$repository = $this->getDoctrine()->getRepository(Etablissement::class);

		$etablissements = $repository->findById($id);
		
		$lienPrecedent = "";
		$lienSuivant = "";
		$lienPremier = "";
		$url = "http://localhost:8000/etablissements/id/";
		if(!empty($repository->findById($id-1)))
			$lienPrecedent = $url.($id-1);
		if(!empty($repository->findById($id+1)))
			$lienSuivant = $url.($id+1);
		
		if($id != 1)
			$lienPremier = $url."1";
	 
		return $this->render('etablissement/affichageTable.html.twig', [
        	'titre' => "Etablissements - Recherche par id",
            'etablissements' => $etablissements,
			'lienPrecedent' => $lienPrecedent,
			'lienSuivant' => $lienSuivant,
			'lienPremier' => $lienPremier
        ]);
    }

    /**
     * @Route("/etablissements/departement/{id}", name="get_etablissements_departement", defaults={"id" = ""})
     */
    public function getEtablissementsDepartement(string $id): Response {
		$page = $_GET["page"];

        $repository = $this->getDoctrine()->getRepository(Etablissement::class);
		if($id == "")
			$id = $repository->findById(1)[0]->getDepartement();
		
		$etablissements = $repository->findByParameterLimit(
			$page, "departement", $id
		);

		$lienPrecedent = "";
		$lienSuivant = "";
		$lienPremier = "";
		$url = "http://localhost:8000/etablissements/departement/";
		if(!empty($repository->findByParameterLimit($page-1, "departement", $id)))
			$lienPrecedent = $url.$id."?page=".($page-1);
		if(!empty($repository->findByParameterLimit($page+1, "departement", $id)))
			$lienSuivant = $url.$id."?page=".($page+1);
		
		if($page != 1)
			$lienPremier = $url.$id."?page=1";

        return $this->render('etablissement/affichageTable.html.twig', [
        	'titre' => "Etablissements - Recherche par département",
            'etablissements' => $etablissements,
			'lienPrecedent' => $lienPrecedent,
			'lienSuivant' => $lienSuivant,
			'lienPremier' => $lienPremier
        ]);
    }

    /**
     * @Route("/etablissements/academie/{id}", name="get_etablissements_academie", defaults={"id" = ""})
     */
    public function getEtablissementsAcademie(string $id): Response {
		$page = $_GET["page"];

        $repository = $this->getDoctrine()->getRepository(Etablissement::class);
		if($id == "")
			$id = $repository->findById(1)[0]->getAcademie();
		
		$etablissements = $repository->findByParameterLimit(
			$page, "academie", $id
		);

		$lienPrecedent = "";
		$lienSuivant = "";
		$lienPremier = "";
		$url = "http://localhost:8000/etablissements/academie/";
		if(!empty($repository->findByParameterLimit($page-1, "academie", $id)))
			$lienPrecedent = $url.$id."?page=".($page-1);
		if(!empty($repository->findByParameterLimit($page+1, "academie", $id)))
			$lienSuivant = $url.$id."?page=".($page+1);
		
		if($page != 1)
			$lienPremier = $url.$id."?page=1";

        return $this->render('etablissement/affichageTable.html.twig', [
        	'titre' => "Etablissements - Recherche par académie",
            'etablissements' => $etablissements,
			'lienPrecedent' => $lienPrecedent,
			'lienSuivant' => $lienSuivant,
			'lienPremier' => $lienPremier
        ]);
    }

	/**
	 * @Route("/etablissements/commune/{id}", name="get_etablissements_commune", defaults={"id" = ""})
	 */
	public function getEtablissementsCommune(string $id): Response {
		$page = $_GET["page"];

        $repository = $this->getDoctrine()->getRepository(Etablissement::class);
		if($id == "")
			$id = $repository->findById(1)[0]->getCommune();
		
		$etablissements = $repository->findByParameterLimit(
			$page, "commune", $id
		);

		$lienPrecedent = "";
		$lienSuivant = "";
		$lienPremier = "";
		$url = "http://localhost:8000/etablissements/commune/";
		if(!empty($repository->findByParameterLimit($page-1, "commune", $id)))
			$lienPrecedent = $url.$id."?page=".($page-1);
		if(!empty($repository->findByParameterLimit($page+1, "commune", $id)))
			$lienSuivant = $url.$id."?page=".($page+1);
		
		if($page != 1)
			$lienPremier = $url.$id."?page=1";

        return $this->render('etablissement/affichageTable.html.twig', [
        	'titre' => "Etablissements - Recherche par commune",
            'etablissements' => $etablissements,
			'lienPrecedent' => $lienPrecedent,
			'lienSuivant' => $lienSuivant,
			'lienPremier' => $lienPremier
        ]);
	}

	/**
	 * @Route("/etablissements/region/{id}", name="get_etablissements_region", defaults={"id" = ""})
	 */
	public function getEtablissementsRegion(string $id): Response {
		$page = $_GET["page"];

        $repository = $this->getDoctrine()->getRepository(Etablissement::class);
		if($id == "")
			$id = $repository->findById(1)[0]->getRegion();
		
		$etablissements = $repository->findByParameterLimit(
			$page, "region", $id
		);

		$lienPrecedent = "";
		$lienSuivant = "";
		$lienPremier = "";
		$url = "http://localhost:8000/etablissements/region/";
		if(!empty($repository->findByParameterLimit($page-1, "region", $id)))
			$lienPrecedent = $url.$id."?page=".($page-1);
		if(!empty($repository->findByParameterLimit($page+1, "region", $id)))
			$lienSuivant = $url.$id."?page=".($page+1);
		
		if($page != 1)
			$lienPremier = $url.$id."?page=1";

        return $this->render('etablissement/affichageTable.html.twig', [
        	'titre' => "Etablissements - Recherche par région",
            'etablissements' => $etablissements,
			'lienPrecedent' => $lienPrecedent,
			'lienSuivant' => $lienSuivant,
			'lienPremier' => $lienPremier
        ]);
	}

	/**
	 * @Route("/etablissements/new", name="new_etablissement")
	 * @Method({"GET", "POST"})
	 */
	public function newEtablissement(Request $request): Response {
		$etablissement = new Etablissement();
		$form = $this->createForm(EtablissementType::class, $etablissement);
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){
			$manager = $this->getDoctrine()->getManager();
			$manager->persist($etablissement);
			$manager->flush();

			return $this->redirectToRoute('get_etablissements_id', array('id' => $etablissement->getId()));
		}
		
		return $this->render('etablissement/form.html.twig', [
			'titre' => "Etablissements - Insertion",
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/etablissements/update/{id}", name="update_etablissement", defaults={"id" = "1"})
	 * @Method({"GET", "POST"})
	 */
	public function updateEtablissement(Request $request, int $id): Response {
		$etablissement = $this->getDoctrine()->getRepository(Etablissement::class)->findById($id)[0];
		$form = $this->createForm(EtablissementType::class, $etablissement);
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){
			$manager = $this->getDoctrine()->getManager();
			$manager->persist($etablissement);
			$manager->flush();

			return $this->redirectToRoute('get_etablissements_id', array('id' => $etablissement->getId()));
		}
		
		return $this->render('etablissement/form.html.twig', [
			'titre' => "Etablissements - Modification",
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/etablissements/cartographieCommune/{id}", name="cartographieCommune", defaults={"id" = ""})
	 */
	public function cartographieCommune(string $id): Response {
		$repository = $this->getDoctrine()->getRepository(Etablissement::class);
		if($id != "")
			$etablissements = $repository->findByCommune($id);
		else
			$etablissements = $repository->findByCommune(
				$repository->findById(1)[0]->getCommune()
			);
		return $this->render('etablissement/cartographie.html.twig', [
			'titre' => "Carte des établissements par commune",
			'etablissements' => $etablissements
		]);
	}
}