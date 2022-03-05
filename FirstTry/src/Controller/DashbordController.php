<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashbordController extends AbstractController
{
    /**
     * @Route("/dashbord", name="dashbord")
     */
    public function index(): Response
    {
        return $this->render('Back-Office/dashbord/index.html.twig', [
            'controller_name' => 'Back-Office/Dashbord/DashbordController',
        ]);
    }




}
   