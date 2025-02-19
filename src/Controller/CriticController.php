<?php

namespace App\Controller;

use App\Entity\Critic;
use App\Form\CriticFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CriticController extends AbstractController
{
    #[Route('/critic', name: 'app_critic')]
    public function index(): Response
    {
        return $this->render('critic/index.html.twig', [
            'controller_name' => 'CriticController',
        ]);
    }

    // -> Add or edit a Critic
    #[Route('/critic/new', name: 'new_critic')]
    #[Route('/critic/{id}/edit', name: 'edit_critic')]
    public function new_edit(Critic $critic = null, Request $request, EntityManagerInterface $entityManager): Response 
    {
        // > If Critic does not exist, create Critic
        if (!$critic) {
            $critic = new Critic();
        }

        $form = $this->createForm(CriticFormType::class, $critic);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // > Fetching datas from the submitted form
            $critic = $form->getData();

            // > 2 steps save in DataBase
            $entityManager->persist($critic);
            $entityManager->flush();

            $this->addFlash('crAddEditSuccess', 'Critic on "'.$critic->getPiece()->getTitle().'" added/edited !');
            return $this->redirectToRoute('app_critic');
        }

        // > Return infos to view
        return $this->render('critic/new.html.twig', [
            'formAddCritic' => $form,
            'edit' => $critic->getId()
        ]);
    }
}
