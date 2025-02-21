<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Entity\Critic;
use App\Form\CriticFormType;
use App\Repository\CriticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
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
    public function new_edit(Critic $critic = null, Request $request, EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrf): Response 
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

            $this->addFlash('crAddEditSuccess', 'Critic on "'.$critic->getPiece()->getTitle().'" by "'.$critic->getInfluencer().'" added/edited !');
            return $this->redirectToRoute('app_critic');
        }

        // > Return infos to view
        return $this->render('critic/new.html.twig', [
            'formAddCritic' => $form,
            'edit' => $critic->getId()
        ]);
    }

    // > Display critics by Piece
    #[Route('/critics/{id}', name: 'show_critics')]
    public function show(Piece $piece = null): Response
    {
        if (!$piece) {
            $this->addFlash('piSearchFail', 'The critics you\'re looking for does not exist !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('critic/show.html.twig', [
            'piece' => $piece,
        ]);
    }
}
