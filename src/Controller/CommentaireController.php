<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Etablissement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CommentaireType;
use Symfony\Component\Validator\Constraints\DateTime;

class CommentaireController extends AbstractController
{
    /**
    * @Route("/commentaires/{id}", name="get_commentaires", defaults={"id" = "1"})
    */
    public function getCommentaires(string $id): Response
    {
        $page = 1;
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        $repository = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaires = $repository->findByEtablissementLimit($page, $id);
        
        $lienPrecedent = "";
        $lienSuivant = "";
        $lienPremier = "";
        $url = "http://localhost:8000/commentaires/";
        if(!empty($repository->findByEtablissementLimit($page-1, $id)))
            $lienPrecedent = $url.$id."?page=".($page-1);
        if(!empty($repository->findByEtablissementLimit($page+1, $id)))
            $lienSuivant = $url.$id."?page=".($page+1);
        
        if($page != 1)
            $lienPremier = $url.$id."?page=1";
        
        $etablissement = $this->getDoctrine()->getRepository(Etablissement::class)->findById($id)[0];
        
        return $this->render('commentaire/affichageTable.html.twig', [
            'titre' => "Commentaires - ". $etablissement->getNom(),
            'nom_etab' => $etablissement->getNom(),
            'id_etab' => $id,
            'commentaires' => $commentaires,
            'lienPrecedent' => $lienPrecedent,
            'lienSuivant' => $lienSuivant,
            'lienPremier' => $lienPremier
        ]);
    }
    
    /**
    * @Route("/commentaires/id/{id}", name="get_commentaire_id", defaults={"id" = "1"})
    */
    public function getCommentairesId(string $id): Response {
        $repository = $this->getDoctrine()->getRepository(Commentaire::class);
        if($id != "") {
            $commentaires = $repository->findById($id);
        }
        else {
            $commentaires = $repository->findById(1);
        }
        return $this->render('commentaire/affichageTable.html.twig', [
            'titre' => "Commentaires - Recherche par id",
            'commentaires' => $commentaires
        ]);
    }
    
    /**
    * @Route("/commentaires/auteur/{id}", name="get_commentaire_auteur", defaults={"id" = ""})
    */
    public function getCommentairesAuteur(string $id): Response {
        $repository = $this->getDoctrine()->getRepository(Commentaire::class);
        if($id != "") {
            $commentaires = $repository->findByAuteur($id);
        }
        else {
            $commentaires = $repository->findByAuteur(1);
        }
        return $this->render('commentaire/affichageTable.html.twig', [
            'titre' => "Commentaires - Recherche par auteur",
            'commentaires' => $commentaires
        ]);
    }
    
    /**
    * @Route("/commentaires/new/{id}", name="new_commentaire")
    * @Method({"GET", "POST"})
    */
    public function newCommentaire(Request $request, string $id): Response {
        $commentaire = new Commentaire();
        $etablissement = $this->getDoctrine()->getRepository(Etablissement::class)->findById($id)[0];
        $commentaire->setEtablissement($etablissement);
        $commentaire->setDate(new \DateTime('now'));
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commentaire);
            $manager->flush();
            
            return $this->redirectToRoute('get_commentaires', array('id' => $id));
        }
        
        return $this->render('commentaire/form.html.twig', [
            'titre' => "Commentaires - Insertion",
            'form' => $form->createView()
        ]);
    }
    
    /**
    * @Route("/commentaires/update/{id}", name="update_commentaire", defaults={"id" = "1"})
    * @Method({"GET", "POST"})
    */
    public function updateCommentaire(Request $request, int $id): Response {
        $commentaire = $this->getDoctrine()->getRepository(Commentaire::class)->findById($id)[0];
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commentaire);
            $manager->flush();

            return $this->redirectToRoute('get_commentaires', array('id' => $commentaire->getEtablissement()->getId()));
        }
        
        return $this->render('commentaire/form.html.twig', [
            'titre' => "Commentaires - Modification",
            'form' => $form->createView()
        ]);
    }
}
    