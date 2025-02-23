<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Piece;
use App\Entity\Category;
use App\Form\PieceFormType;
use App\Repository\PieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PieceController extends AbstractController
{
    // -> Add or edit a Piece
    #[Route('/piece/new', name: 'new_piece')]
    #[Route('/piece/{id}/edit', name: 'edit_piece')]
    public function new_edit(Piece $piece = null, 
    Request $request, 
    EntityManagerInterface $entityManager,
    SluggerInterface $slugger,
    CsrfTokenManagerInterface $csrf,
    #[Autowire('%kernel.project_dir%/public/uploads/images')] string $imagesDirectory
    ): Response
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
            $imageFile = $form->get('link')->getData();
            
            // > If a new photo is submitted
            if ($imageFile) {
                $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName.'-'.uniqid().'.'.$imageFile->guessExtension();

                // > Moving uploaded image to directory
                try {
                    $imageFile->move($imagesDirectory, $newFileName);
                } catch (FileException $e) {
                    ('An error occured while uploading the file : '.$e->getMessage()); die;
                }
            } 
            // > Else : image stays the same
            else {
                $newFileName = $piece->getImages();
            }

            // > Photo is set with file name in the entity
            $influencer->setImage($newFileName);
            
            // > 2 steps save in DataBase
            $entityManager->persist($piece);
            $entityManager->flush();
            
            $this->addFlash('piAddEditSuccess', ' "'.$piece.'" added/edited !');
            return $this->redirectToRoute('app_home');
        }
        
        // > Return infos to view
        return $this->render('piece/new.html.twig', [
            'formAddPiece' => $form,
            'edit' => $piece->getId()
        ]);
    }

    // > Display pieces by Category
    #[Route('/category/{id}', name: 'show_category')]
    public function show(Category $category = null): Response
    {
        if (!$category) {
            $this->addFlash('caSearchFail', 'The category you\'re looking for does not exist !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('piece/index.html.twig', [
            'category' => $category,
        ]);
    }

    // > Display piece details
    #[Route('/piece/{id}/show', name: 'show_piece')]
    public function showPiece(Piece $piece = null): Response
    {
        if (!$piece) {
            $this->addFlash('piSearchFail', 'The piece you\'re looking for does not exist !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('piece/show.html.twig', [
            'piece' => $piece
        ]);
    }
}
