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
    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    #[Route('/task/new', name: 'app_task_create')]
    public function createTask(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        // création d'une instance de l'entité Task
        $task = new Task();

        // dans l'abstract controller, on crée un formulaire de type Task et on y passe notre variable task
        $form = $this->createForm(TaskType::class, $task);   
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task');

        // au render je donne le nom du template que je veux et je donne la view (le contenu et tout) du formulaire
        return $this->render('task/index.html.twig',
        [
            'taskForm' => $form->createView(),
        ]);

        }
    }
}