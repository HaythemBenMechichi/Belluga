<?php

namespace App\Controller;

use App\Entity\EventProd;
use App\Form\EventProdType;
use App\Repository\EventProdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventProdController extends AbstractController
{
    /**
     * @Route("/event/prod", name="event_prod")
     */
    public function index(): Response
    {
        return $this->render('event_prod/home.html.twig', [
            'controller_name' => 'EventProdController',
        ]);
    }
    /**
     * @Route("/admin2", name="admin2")
     */
    public function admin(): Response
    {
        return $this->render('event_prod/dashboard2.html.twig', [
            'controller_name' => 'EventProdController',
        ]);
    }

/**
 * @param EventProdRepository $repository
 * @return Response
 * @Route ("/Afficher", name="Afficher")
 */
function Afficher(EventProdRepository $repository ){

    $eventprod=$repository->findAll();
    return $this->render('/event_prod/eventProdaffiche.html.twig',
        [
            'eventProd'=>$eventprod
        ]);
}

/**
 * @Route ("/DeleteEvt/{id}", name="deleteEvt")
 */
function Delete($id,EventProdRepository $rep){
    $eventprod=$rep->find($id);
    $em=$this->getDoctrine()->getManager();
    $em->remove($eventprod);
    $em->flush();
    return $this->redirectToRoute('Afficher');

}

/**
 * @Route("/Ajouter",name="Ajouter")
 */
public function Ajout (Request $request){
    $eventprod=new EventProd();
    $form=$this->createForm(EventProdType::class,$eventprod);
    //$form->add('Ajout',SubmitType::class);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
        $em=$this->getDoctrine()->getManager();
        $em->persist($eventprod);
        $em->flush();
        return $this->redirectToRoute('Afficher');

    }
    return $this->render('event_prod/ajouterEventProd.html.twig',
        ['f'=>$form->createView()]);

}

/**
 * @Route("eventProd/Update/{id}",name="update")
 */
function Update(EventProdRepository $repository,$id,Request $request)
{
    $eventprod = $repository->find($id);
    $form = $this->createForm(EventProdType::class, $eventprod);
    //$form->add('Update', SubmitType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("Afficher");
    }
    return $this->render('event_prod/updateEventProd.html.twig',
        [
            'f' => $form->createView(),
            "form_title" => "Modifier un Event Produit"
        ]);
}

}
