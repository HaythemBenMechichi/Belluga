<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;

use App\Form\AjoutCatType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



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
      * @Route("/produit", name="afficheCategorie")
      */
      public function afficheCate()
      {
         $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
         $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
         $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();

         return $this->render('Front-Office/produit/index.html.twig', [
           "categories" => $categories, "produits" => $produits,    
         ]);
      }



     /**
     * @Route("/table", name="afficheProduitBack")
     */
    public function afficheProd()
    {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('Back-Office/table.html.twig', [
            "produits" => $produits,"categories" => $categories,
        ]);
    }




  /**
     * @Route("/ajoutCat", name="AjoutCategorie", methods={"GET", "POST"})
     */
         public function addcategories(Request $request): Response
         {
             $categories = new Categorie();
             $form = $this->createForm(AjoutCatType::class, $categories);
                 $form->add('Ajouter',SubmitType::class);
             $form->handleRequest($request);
             if($form->isSubmitted() && $form->isValid())
             {
                 $images= $form->get('imageCar')->getData();
                 $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                 $images->move($this->getParameter('upload_directory'), $fichier);
                 $categories->setImageCar($fichier);
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($categories);
                 $entityManager->flush();
                 return $this->redirectToRoute('affiche');
             }
             return $this->render("Back-Office/ajoutCat/ajoutCat.html.twig", [
                 "CategorieForm" => $form->createView(),
             ]); 
    }


  /**
     * @Route("/modifierCategorie/{id}", name="ModifCategorie", methods={"GET", "POST"})
     */

     function UpdateCategorie(CategorieRepository $repository,$id,Request $request)
     {
         $categories = $repository->find($id);
         $form = $this->createForm(AjoutCatType::class, $categories);
         $form->add('Update', SubmitType::class);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageCar']->getData();
            if ($uploadedFile)
            {
                $destination = $this->getParameter('upload_directory');
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $categories->setImageCar($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affiche');
         }
         return $this->render('Back-Office/ModifCat/ModifCat.html.twig',
             [
                 'CategorieForm' => $form->createView(),
             ]);
     }




    
    /** 
    * @Route ("/DeleteCategorie/{id}", name="del")
    */
   function Delete($id,CategorieRepository $rep){
    $categorie=$rep->find($id);
    $em=$this->getDoctrine()->getManager();
    $em->remove($categorie);
    $em->flush();
    return $this->redirectToRoute('affiche');

}



    

}