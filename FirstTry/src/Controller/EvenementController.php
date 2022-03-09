<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/home.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(): Response
    {
        return $this->render('evenement/dashboard.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }


    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route ("/Affiche", name="Affiche")
     */
    function Afficher(EvenementRepository $repository ){

        $evenement=$repository->findAll();
        return $this->render('/evenement/Affiche.html.twig',
            [
                'evenement'=>$evenement
            ]);
    }

    /**
     * @Route("/evenements/searchResajax ", name="searchResajax")
     */
    public function searchEventAjax(EvenementRepository $repo,Request $request)
    {
        $requestString=$request->get('searchValue');
        $events = $repo->findEventByName($requestString);

        return $this->render('evenement/ajax.html.twig', [
            "evenement"=>$events
        ]);
    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route ("/triA", name="triA")
     */
    function Affichertri(EvenementRepository $repository ){

        $evenement=$repository->orderByNameAscQB();
        return $this->render('/evenement/Affiche.html.twig',
            [
                'evenement'=>$evenement
            ]);
    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route ("/triD", name="triD")
     */
    function AffichertrDi(EvenementRepository $repository ){

        $evenement=$repository->orderByNameDescQB();
        return $this->render('/evenement/Affiche.html.twig',
            [
                'evenement'=>$evenement
            ]);
    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route ("/triDateD", name="triDateD")
     */
    function AffichertrDiDate(EvenementRepository $repository ){

        $evenement=$repository->orderByDateDescQB();
        return $this->render('/evenement/Affiche.html.twig',
            [
                'evenement'=>$evenement
            ]);
    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route ("/triDateA", name="triDateA")
     */
    function AffichertrAscDate(EvenementRepository $repository ){

        $evenement=$repository->orderByDateAscQB();
        return $this->render('/evenement/Affiche.html.twig',
            [
                'evenement'=>$evenement
            ]);
    }

    /**
     * @param $id
     * @Route ("/Delete/{id}", name="delete")
     */
    function Delete($id,EvenementRepository $rep){
        $evenement=$rep->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('Affiche');

    }
    /**
     * @Route("/Ajout",name="Ajout")
     */
    public function Ajout (Request $request, \Swift_Mailer $mailer, UserRepository $repo){
        $evenement=new Evenement();
        $form=$this->createForm(EvenementType::class,$evenement);
        //$form->add('Ajout',SubmitType::class);
        $form->handleRequest($request);
        $file=$form['image']->getData();

        $users = $repo->findAll();
        if($form->isSubmitted() && $form->isValid())
        {   $uploads_dir=$this->getParameter('uploads_directory');
            $filename=md5(uniqid())  .'.'. $file->guessExtension();
            $file->move($uploads_dir,$filename);
            $evenement->setImage($filename);
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            foreach ($users as $user){
            $message = (new \Swift_Message('Princeps - ' . $evenement->getNom()))
                ->setFrom('princeps.ordre@gmail.com')
                ->setTo($user->getMail())
                ->setBody('Un nouvel événement plein de promotions vous attend!');

            $mailer->send($message);
            }
            return $this->redirectToRoute('Affiche');


        }
        return $this->render('evenement/Ajout.html.twig',
            ['f'=>$form->createView()]);

    }
    /**
     * @Route("evenement/Update/{id}",name="updateEvt")
     */
    function Update(EvenementRepository $repository,$id,Request $request)
    {
        $evenement = $repository->find($id);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("Affiche");
        }
        return $this->render('evenement/evenementUpdate.html.twig',
            [
                'f' => $form->createView(),
                "form_title" => "Modifier un evenement"
            ]);
    }

    /**
     * @Route ("/Ajouterevenement")
     * @Method ("POST")
     */
    public function ajoutermobile(Request $request){

        $event = new Evenement();

        $em=$this->getDoctrine()->getManager();

        $DateDebut=$request->query->get("DateDebut");
        $event->setDateDebut($DateDebut);

        $DateFin=$request->query->get("DateFin");
        $event->setDateFin($DateFin);

        $nom=$request->query->get("nom");
        $event->setNom($nom);

        $image=$request->query->get("image");
        $event->setImage($image);

        $em->persist($event);
        $em->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $aj = $serializer->normalize($event);
        return new JsonResponse($aj);

    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route("/events")
     */
    public function indexmobile(EvenementRepository $rep,SerializerInterface $serializer)
    {
        $event =$rep->findAll();


        $aj = $serializer->normalize($event,'json',['groups'=>'events']);
        return new JsonResponse($aj);

    }
    /**
     * @Route ("/Deleteevent")
     * @Method("DELETE")
     */
    function SupprimerFrontmoibile(Request $request , EvenementRepository $repository){
        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();

        $event =$em->getRepository(Evenement::class)->find($id);
        $em->remove($event);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $aj = $serializer->normalize($event);
        return new JsonResponse($aj);
    }


/**
* @Route ("/calendrier",name="Calendrier")
*/
    public function Calendrier(){
        return $this->render('evenement/calendrier.html.twig');
    }






}

