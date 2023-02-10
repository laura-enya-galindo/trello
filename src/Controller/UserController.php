<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
use App\Form\UserType;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route("/user/create", name:"trello_user_form")]
    #[Route("/user/create/{id}", name:"trello_user_test_edit")]
    public function editUser(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $user = new User();

        if ($id === null) {
            $user = new User();
        } else {
            $user = $entityManager->getRepository(User::class)->find($id);
        }

        $form = $this->createForm(UserType::class, $user);


        // On met à jour du coup notre entité book avec les données récupérées via le formulaire.
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('trello_user_test_edit', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('user.html.twig',
        [
            'userForm' => $form->createView(),
        ]);

    }
}
