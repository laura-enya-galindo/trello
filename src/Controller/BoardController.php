<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\TaskRepository;
// use App\Repository\UserRepository;
// use App\Repository\StatusRepository;


class BoardController extends AbstractController
{
    #[Route('/board', name: 'app_board')]
    public function index(TaskRepository $taskRepository): Response
    {
        $task = $taskRepository->findAll();
        // $users = $userRepository->findAll();
        // $status = $statusRepository->findAll();

        return $this->render('board/index.html.twig', [
            'task' => $task,
            // 'status' => $status,
            // 'users' => $users,
        ]);
    }
}
