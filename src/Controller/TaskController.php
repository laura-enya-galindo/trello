<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Task;
use App\Form\TaskType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class TaskController extends AbstractController
{
    // #[Route('/task', name: 'app_task')]
    // public function index(): Response
    // {
    //     return $this->render('task/index.html.twig', [
    //         'controller_name' => 'TaskController',
    //     ]);
    // }

    #[Route('/task', name: 'app_create_task')]
    public function editTask(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task(); 
        $form = $this->createForm(TaskType::class, $task);
        // dd($form);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager->persist($task);
            // $entityManager->flush();
            $task = $form->getData();
        }
        return $this->render('task/index.html.twig',
        [
            'taskForm' => $form,
        ]);
    }

}
