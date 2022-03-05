<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\SousCategorie;
use App\Form\FormProduitType;
use App\Form\ModifProdType;
use App\Form\ModifProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Entity;
use AppBundle\Repository\EntityRepository;
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
     * @Route("/table", name="affiche")
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
     * @Route("/DetailedProduit/{idSousCat}/{id}", name="affiche_Detailed")
     */
    public function afficheProdDetailed($id,$idSousCat)
    {
        $sous=$this->getDoctrine()->getRepository(SousCategorie::class)->findOneBy([ 'nomSous' => $idSousCat]);
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $prods = $this->getDoctrine()->getRepository(Produit::class)->findBy([ 'idSousCat' =>$sous]);

        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        return $this->render('Front-office/produit/DetailedProduit.html.twig', [
            "produit" => $produit,"categories" => $categories,"prods"=>$prods
        ]);
    
    
    }




    

     /**
     * @Route("/produit/{id}", name="affiche_TRI")
     */
    public function afficheProdTri($id)
    {
        $sous=$this->getDoctrine()->getRepository(SousCategorie::class)->findOneBy([ 'idCat' => $id]);
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findBy([ 'idSousCat' =>$sous]);
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('Front-office/produit/Tri.html.twig', [
            "produits" => $produits,"categories" => $categories
        ]);
    }

     
     /**
     * @Route("/produit/tri", name="affiche_TRI")
     */
    public function afficheProdFiltre()
    {
        
        $produits =$this->getDoctrine()->getRepository(Produit::class)->findBy([], ['prix' => 'ASC']);
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('Front-office/produit/Filtre.html.twig', [
            "produits" => $produits,"categories" => $categories
        ]);
    }


     /**
     * @Route("/produit/triD", name="affiche_TRI")
     */
    public function afficheProdFiltreD()
    {
        
        $produits =$this->getDoctrine()->getRepository(Produit::class)->findBy([], ['prix' => 'DESC']);
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('Front-office/produit/Filtre.html.twig', [
            "produits" => $produits,"categories" => $categories
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
            return $this->redirectToRoute('affiche');
        }
        return $this->render("Back-Office/AjoutProduit/Ajoutproduit.html.twig", [
            "ProduitForm" => $form->createView(),
        ]);
    }



 /**
     * @Route("/modifierProduit/{id}", name="modif" , methods={"GET", "POST"})
 */

 
function UpdateProd(ProduitRepository $repository,$id,Request $request)
     {
         $produits = $repository->find($id);
         $form = $this->createForm(FormProduitType::class, $produits);
         $form->add('Update', SubmitType::class);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageP']->getData();
            if ($uploadedFile)
            {
                $destination = $this->getParameter('upload_directory');
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $produits->setImageP($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affiche');
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
       return $this->redirectToRoute('affiche');
   }





    /** 
    * @Route ("/search", name="Search")
    */
   public function searchAction(Request $request,ProduitRepository $rep)
{
    $em=$this->getDoctrine()->getManager();
    $requestString=$request->get('q');
    $entities =  $rep->findEntitiesByString($requestString);
 if(!$entities)
 {
     $result['entities']['error'] = "aucun Produit";
 }
 else
 {
    $result['entities'] = $this->getRealEntities($entities);
 }
 return new Response(json_encode($result));
} 

public function getRealEntities($entities){
    foreach($entities as $entity)
    {
        $realEntities[$entity->getId()]=[$entity->getImageP(),$entity->getLibelle()];
    }
}
}
