<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
    
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class MobileProduitController extends AbstractController
{
    /**
     * @Route("/mobile/produit", name="mobile_produit")
     */
    public function index(): Response
    {
        return $this->render('mobile_produit/index.html.twig', [
            'controller_name' => 'MobileProduitController',
        ]);
    }


     /**
     * @Route("/mobile/produitAffiche", name="afficheMobile")
     */
    public function afficheProdMobile( SerializerInterface $serializer) :Response
    {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        $json = $serializer->serialize($produits, 'json',['produits'=>['show_product']]);
        return new JsonResponse([
        'show_product' => $json,
         ]);
    }

}
