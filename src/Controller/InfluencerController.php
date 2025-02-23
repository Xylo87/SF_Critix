<?php

namespace App\Controller;

use App\Entity\Influencer;
use App\Form\InfluencerFormType;
use App\Repository\InfluencerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class InfluencerController extends AbstractController
{   
    // > Influencers listing
    #[Route('/influencers', name: 'app_influencer')]
    public function index(InfluencerRepository $influencerRepository): Response
    {
        $influencers = $influencerRepository->findBy([], ["nickName" => "ASC"]);

        return $this->render('influencer/index.html.twig', [
            'controller_name' => 'InfluencerController',
            'influencers' => $influencers
        ]);
    }

    // -> Add or edit a Influencer
    #[Route('/influencer/new', name: 'new_influencer')]
    #[Route('/influencer/{id}/edit', name: 'edit_influencer')]
    public function new_edit(Influencer $influencer = null, 
    Request $request, 
    EntityManagerInterface $entityManager,
    SluggerInterface $slugger,
    CsrfTokenManagerInterface $csrf,
    #[Autowire('%kernel.project_dir%/public/uploads/photos/influPhotos')] string $photosDirectory
    ): Response 
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
            $photoFile = $form->get('photo')->getData();

            // > If a new photo is submitted
            if ($photoFile) {
                $originalFileName = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName.'-'.uniqid().'.'.$photoFile->guessExtension();

                // > Moving uploaded photo to directory
                try {
                    $photoFile->move($photosDirectory, $newFileName);
                } catch (FileException $e) {
                    ('An error occured while uploading the file : '.$e->getMessage()); die;
                }
            } 
            // > Else : photo stays the same
            else {
                $newFileName = $influencer->getPhoto();
            }

            // > Photo is set with file name in the entity
            $influencer->setPhoto($newFileName);

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

    #[Route('/influencer/{id}', name: 'show_influencer')]
    public function show(Influencer $influencer): Response
    {
        if (!$influencer) {
            $this->addFlash('inSearchFail', 'Content creator you\'re looking for does not exist !');
            return $this->redirectToRoute('app_influencer');
        }

        return $this->render('influencer/show.html.twig', [
            'influencer' => $influencer
        ]);
    }
}
