<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Form\UserType;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
    *@Route("/victorious/elephant/book", name="app_victorious_elephant_test")
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
