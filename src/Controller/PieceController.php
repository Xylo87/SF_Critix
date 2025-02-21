<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Entity\Category;
use App\Form\PieceFormType;
use App\Repository\PieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PieceController extends AbstractController
{
    // -> Add or edit a Piece
    #[Route('/piece/new', name: 'new_piece')]
    #[Route('/piece/{id}/edit', name: 'edit_piece')]
    public function new_edit(Piece $piece = null, Request $request, EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrf): Response 
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
            
            $this->addFlash('piAddEditSuccess', ' "'.$piece.'" added/edited !');
            return $this->redirectToRoute('app_piece');
        }
        
        // > Return infos to view
        return $this->render('piece/new.html.twig', [
            'formAddPiece' => $form,
            'edit' => $piece->getId()
        ]);
    }

    // > Display pieces by Category
    #[Route('/category/{id}', name: 'show_category')]
    public function show(Category $category, PieceRepository $pieceRepository): Response
    {
        if (!$category) {
            $this->addFlash('caSearchFail', 'Category you\'re looking for does not exist !');
            return $this->redirectToRoute('app_home');
        }

        $pieces = $pieceRepository->findBy(['category' => $category]);

        return $this->render('piece/show.html.twig', [
            'category' => $category,
            'pieces' => $pieces
        ]);
    }
}
