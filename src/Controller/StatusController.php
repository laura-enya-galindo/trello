<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Status;
use Doctrine\Persistence\ManagerRegistry;

class StatusController extends AbstractController
{
    #[Route('/status', name: 'app_status')]
    public function index(): Response
    {
        return $this->render('status/index.html.twig', [
            'controller_name' => 'StatusController',
        ]);
    }

    # https://symfony.com/doc/5.4/doctrine.html#persisting-objects-to-the-database
    
    // #[Route('/status', name: 'create_status')]
    // public function createStatus(ManagerRegistry $doctrine): Response
    // {
    //     $entityManager = $doctrine->getManager();

    //     $status = new Status();
    //     $status->setLabel('Traité');

    //     // tell Doctrine you want to (eventually) save the Status (no queries yet)
    //     $entityManager->persist($status);

    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();

    //     return new Response('Saved new status with id '.$status->getId());
    // }
}


