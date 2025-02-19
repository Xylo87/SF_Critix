<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Form\PieceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PieceController extends AbstractController
{
    #[Route('/piece', name: 'app_piece')]
    public function index(): Response
    {
        return $this->render('piece/index.html.twig', [
            'controller_name' => 'PieceController',
        ]);
    }

    // -> Add or edit a Piece
    #[Route('/piece/new', name: 'new_piece')]
    #[Route('/piece/{id}/edit', name: 'edit_piece')]
    public function new_edit(Piece $piece = null, Request $request, EntityManagerInterface $entityManager): Response 
    {
        // > If Piece does not exist, create Piece
        if (!$piece) {
            $piece = new Piece();
        }

        $form = $this->createForm(PieceFormType::class, $piece);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // > Fetching datas from the submitted form
            $piece = $form->getData();

            // > 2 steps save in DataBase
            $entityManager->persist($piece);
            $entityManager->flush();

            $this->addFlash('piAddEditSuccess', ' "'.$piece->getTitle().'" added/edited !');
            return $this->redirectToRoute('app_piece');
        }

        // > Return infos to view
        return $this->render('piece/new.html.twig', [
            'formAddPiece' => $form,
            'edit' => $piece->getId()
        ]);
    }
}
