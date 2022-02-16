<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\FormProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;




class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(): Response
    {
        return $this->render('Front-Office/produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }

      /**
      * @Route("/produit", name="produit")
      */
     public function afficheCat()
     {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('Front-Office/index.html.twig', [
            "categories" => $categories,
        ]);
    }

    
     /**
     * @Route("/table", name="affiche")
     */
    public function afficheProd()
    {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('Back-Office/table.html.twig', [
            "produits" => $produits,
        ]);
    }
    

/**
     * @Route("/table", name="table")
     */
    public function table(): Response
    {
        return $this->render('Back-Office/table.html.twig', [
            'controller_name' => 'Back-Office/ProduitController',
        ]);
    }


  /**
     * @Route("/ajoutProduit", name="AjoutProduit", methods={"GET", "POST"})
     */
    public function addproduits(Request $request): Response
    {
        $produits = new produit();
        $form = $this->createForm(FormProduitType::class, $produits);
            $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $images= $form->get('imageP')->getData();
            $fichier = md5(uniqid()) . '.' . $images->guessExtension();
            $images->move($this->getParameter('upload_directory'), $fichier);
            $produits->setImageP($fichier);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produits);
            $entityManager->flush();
            return $this->redirectToRoute('table');
        }
        return $this->render("Back-Office/AjoutProduit/Ajoutproduit.html.twig", [
            "ProduitForm" => $form->createView(),
        ]);
    }
    

 /**
     * @Route("/modifierProduit/{id}", name="modif" , methods={"GET", "POST"})
 */

    function Update(ProduitRepository $repository,$id,Request $request)
    {
        $produits = $repository->find($id);
        $form = $this->createForm(FormProduitType::class, $produits);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $images= $form->get('imageP')->getData();
            $fichier = md5(uniqid()) . '.' . $images->guessExtension();
            $images->move($this->getParameter('upload_directory'), $fichier);
            $produits->setImageP($fichier);


            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("table");
        }
        return $this->render('Back-Office/ModifProduit/ModifProduit.html.twig',
            [
                'ProduitForm' => $form->createView(),
            ]);
    }

    /** 
    * @Route ("/DeleteProduit/{id}", name="d")
    */
   function Delete($id,ProduitRepository $rep){
       $classroom=$rep->find($id);
       $em=$this->getDoctrine()->getManager();
       $em->remove($classroom);
       $em->flush();
       return $this->redirectToRoute('table');

   }





    

}
