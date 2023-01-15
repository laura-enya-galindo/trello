<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    /**
    *@Route("/user/create", name="trello_user_form")
    */
    public function editUser(): Response
    {
        $user = new User();  
        $form = $this->createForm(UserType::class, $user);
 
        return $this->render('user.html.twig',
        [
            'userForm' => $form->createView(),
        ]);
    }
}
