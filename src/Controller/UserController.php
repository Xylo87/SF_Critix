<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UserController extends AbstractController
{
    // #[Route('/user', name: 'app_user')]
    // public function index(): Response
    // {
    //     return $this->render('user/index.html.twig', [
    //         'controller_name' => 'UserController',
    //     ]);
    // }

    // > Display a User page
    #[Route('/user/{id}', name: 'show_user')]
    public function showUser(User $user = null): Response
    {
        if (!$user) {
            $this->addFlash('usSearchFail', 'The user you\'re looking for does not exist !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }
}
