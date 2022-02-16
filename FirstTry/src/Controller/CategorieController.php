<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }


      /**
     * @Route("/produit", name="produit")
     */
    public function afficheCat()
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
    
        return $this->render('produit/index.html.twig', [
            "categories" => $categories,
        ]);
    } 
    
}
