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
    #[Route('task/{id}', name: 'app_task_edit')]
    public function editTask(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $task = new Task();

        if ($id === null) {
            $task = new Task();
        } else {
            $task = $entityManager->getRepository(Task::class)->find($id);
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_edit', [
                'id' => $task->getId()
            ]);
        }

        return $this->render('task/index.html.twig',
        [
            'taskForm' => $form->createView(),
        ]); 
    }

}