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
            return $this->redirectToRoute('app_home');
        }

        // > Return infos to view
        return $this->render('critic/new.html.twig', [
            'formAddCritic' => $form,
            'edit' => $critic->getId()
        ]);
    }

    // -> Delete a Critic
    #[Route('/critic/{id}/delete', name: 'delete_critic')]
    public function delete(Critic $critic, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($critic);
        $entityManager->flush();

        $this->addFlash('crDeleteSuccess', 'Critic on "'.$critic->getPiece()->getTitle().'" by "'.$critic->getInfluencer().'" deleted !');
        return $this->redirectToRoute('app_home');
    }

    // > Display critics by Piece
    #[Route('/critics/{id}', name: 'show_critics')]
    public function showCritics(Piece $piece = null): Response
    {
        if (!$piece) {
            $this->addFlash('crSearchFail', 'The critics you\'re looking for does not exist !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('critic/show.html.twig', [
            'piece' => $piece
        ]);
    }
}
