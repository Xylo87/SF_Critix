<?php

namespace App\Controller;

use App\Entity\Influencer;
use App\Form\InfluencerFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class InfluencerController extends AbstractController
{
    #[Route('/influencer', name: 'app_influencer')]
    public function index(): Response
    {
        return $this->render('influencer/index.html.twig', [
            'controller_name' => 'InfluencerController',
        ]);
    }

    // -> Add or edit a Influencer
    #[Route('/influencer/new', name: 'new_influencer')]
    #[Route('/influencer/{id}/edit', name: 'edit_influencer')]
    public function new_edit(Influencer $influencer = null, Request $request, EntityManagerInterface $entityManager): Response 
    {
        // > If Influencer does not exist, create Influencer
        if (!$influencer) {
            $influencer = new Influencer();
        }

        $form = $this->createForm(InfluencerFormType::class, $influencer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // > Fetching datas from the submitted form
            $influencer = $form->getData();

            // > 2 steps save in DataBase
            $entityManager->persist($influencer);
            $entityManager->flush();

            $this->addFlash('inAddEditSuccess', ' "'.$influencer.'" added/edited !');
            return $this->redirectToRoute('app_influencer');
        }

        // > Return infos to view
        return $this->render('influencer/new.html.twig', [
            'formAddInfluencer' => $form,
            'edit' => $influencer->getId()
        ]);
    }
}
