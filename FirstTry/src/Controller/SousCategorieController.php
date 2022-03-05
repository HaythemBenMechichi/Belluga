<?php

namespace App\Controller;

use App\Entity\SousCategorie;
use App\Form\SousCategorieType;
use App\Repository\SousCategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SousCategorieController extends AbstractController
{
    /**
     * @Route("/Sous", name="sous_categorie",  methods={"GET", "POST"})
     */
    public function index(SousCategorieRepository $sousCategorieRepository): Response
    {
        return $this->render('Back-Office/SousCat/AfficheSous.html.twig', [
            'sous_categories' => $sousCategorieRepository->findAll(),
        ]);
    }



    
     /**
     * @Route("/AfficheSous/{idCat}", name="afficheSous")
     */
    public function afficheSousCat($idCat)
    {
        $SousCategories = $this->getDoctrine()->getRepository(SousCategorie::class)->findBy([ 'idCat' => $idCat]);
        return $this->render('Back-Office/SousCat/AfficheSous.html.twig', [
            "SousCategories" => $SousCategories,
        ]);
    }
    


  

}
