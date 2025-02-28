<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Piece;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, CsrfTokenManagerInterface $csrf,): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

     // > User's dashboard
     #[Route('/user/dashboard', name: 'dashboard_user')]
     public function dashboardUser(User $user = null, Security $security): Response
     {
        $user = $security->getUser();

         if (!$user) {
             $this->addFlash('usSearchFail', 'You must be logged in to access dashboard !');
             return $this->redirectToRoute('app_login');
         }
 
         return $this->render('user/dashboard.html.twig', [
             'user' => $user
         ]);
     }

    // > Save a critics page
    #[Route('/critics/{id}/save', name: 'save_critics')]
    public function saveCritics(Security $security, EntityManagerInterface $entityManager, Piece $piece)
    {
        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('crSaveFail', 'You must be logged in to save a critics page !');
            return $this->redirectToRoute('app_login');
        }

        $user->addPiece($piece);
    
        $entityManager->persist($user);
        $entityManager->flush();
    
        $this->addFlash('crSaveSuccess', 'Critics on "'.$piece.'" saved on your profile !');
        return $this->redirectToRoute('show_critics', ['id' => $piece->getId()]);
    }

    // > Unsave a critics page
    #[Route('/critics/{id}/unsave', name: 'unsave_critics')]
    public function unsaveCritics(Security $security, EntityManagerInterface $entityManager, Piece $piece, Request $request)
    {
        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('crUnSaveFail', 'You must be logged in to unsave a critics page !');
            return $this->redirectToRoute('app_login');
        }

        $user->removePiece($piece);
    
        $entityManager->persist($user);
        $entityManager->flush();
    
        $this->addFlash('crUnSaveSuccess', 'Critics on "'.$piece.'" unsaved ! ');

        // > Custom routing from origin page
        $origin = $request->query->get('origin');

        if ($origin === 'criticsPage' ) {
            return $this->redirectToRoute('show_critics', ['id' => $piece->getId()]);
        } else {
            return $this->redirectToRoute('dashboard_user');
        }
    }

    // > Edit User's infos
    #[Route('/user/edit', name: 'edit_user')]
    public function edit(User $user = null,
    Request $request, 
    EntityManagerInterface $entityManager,
    SluggerInterface $slugger,
    CsrfTokenManagerInterface $csrf,
    #[Autowire('%kernel.project_dir%/public/uploads/photos/userPhotos')] string $photosDirectory,
    Security $security
    ): Response
    {
        $user = $security->getUser();

        // > If User is not logged, return to Login page
        if (!$user) {
            $this->addFlash('usEditFail', 'You must be logged in to edit your profile !');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $photoFile = $form->get('profilePicture')->getData();

            // > If a new photo is submitted
            if ($photoFile) {

                // > Delete User's previous custom profile picture
                $profilePictureName = $user->getProfilePicture();

                if ($profilePictureName) {
                    $profilePicturePath = $this->getParameter('kernel.project_dir') . '/public/uploads/photos/userPhotos/'.$profilePictureName;
            
                    if (file_exists($profilePicturePath)) {
                        unlink($profilePicturePath);
                    }
                }

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
                $newFileName = $user->getProfilePicture();
            }

            // > Photo is set with file name in the entity
            $user->setProfilePicture($newFileName);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('usEditSuccess', 'Your profile has been updated !');
            return $this->redirectToRoute('dashboard_user');
        }

        // > Return infos to view
        return $this->render('user/edit.html.twig', [
            'formAddUser' => $form,
        ]);
    }

    // -> Delete User's account
    #[Route('/user/delete', name: 'delete_user')]
    public function delete(EntityManagerInterface $entityManager, Security $security, TokenStorageInterface $tokenStorage)
    {
        $user = $security->getUser();

        // > If User is not logged, return to Login page
        if (!$user) {
            $this->addFlash('usDeleteFail', 'You must be logged in to delete your profile !');
            return $this->redirectToRoute('app_login');
        }

        // > Delete User's custom profile picture
        $profilePictureName = $user->getProfilePicture();

        if ($profilePictureName) {
            $profilePicturePath = $this->getParameter('kernel.project_dir') . '/public/uploads/photos/userPhotos/'.$profilePictureName;
    
            if (file_exists($profilePicturePath)) {
                unlink($profilePicturePath);
            }
        }

        $tokenStorage->setToken(null);
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $session = $request->getSession();
        $session->invalidate();

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('usDeleteSuccess', 'Your profile has been deleted !');
        return $this->redirectToRoute('app_home');
    }
}