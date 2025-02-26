<?php

namespace App\Controller;

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

    // > Edit User's infos
    #[Route('/user/edit', name: 'edit_user')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
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

        if (!$user) {
            $this->addFlash('usEditFail', 'You must be logged in to edit your profile !');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('usEditSuccess', 'Your profile has been updated !');
            return $this->redirectToRoute('show_user', ['id' => $user->getId()]);
        }

        // > Return infos to view
        return $this->render('user/new.html.twig', [
            'formAddUser' => $form,
        ]);
    }
}
