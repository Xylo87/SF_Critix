<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Piece;
use App\Entity\Critic;
use App\Entity\Comment;
use App\Entity\Opinion;
use App\Entity\Agreement;
use App\Entity\Influencer;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\OpinionRepository;
use App\Repository\AgreementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Freema\PerspectiveApiBundle\Service\PerspectiveApiService;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error) {
            $this->addFlash('login_error', $error->getMessageKey());
        }

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
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
    // #[Route('/critics/{id}/save', name: 'save_critics')]
    // public function saveCritics(Security $security, EntityManagerInterface $entityManager, Piece $piece = null)
    // {
    //     $user = $security->getUser();

    //     if (!$user) {
    //         $this->addFlash('crSaveFail', 'You must be logged in to save a critics page !');
    //         return $this->redirectToRoute('app_login');
    //     }

    //     $user->addPiece($piece);
    
    //     $entityManager->persist($user);
    //     $entityManager->flush();
    
    //     $this->addFlash('crSaveSuccess', 'Critics on "'.$piece.'" saved on your dashboard !');
    //     return $this->redirectToRoute('show_critics', ['id' => $piece->getId()]);
    // }

    // > Save/Unsave a critics page (AJAX ver.)
    #[Route('/critics/{id}/{action}', name: 'save_critics', methods: ['POST'])]
    public function saveCritics(Security $security, EntityManagerInterface $entityManager, Piece $piece = null, Request $request, string $action)
    {
        $user = $security->getUser();

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'You must be logged in to ' . ($action === 'save' ? 'save' : 'unsave') . ' a critics page !'
            ], 401);
        }

        if ($action === 'save') {
            $user->addPiece($piece);
            $message = 'Critics on "'.$piece.'" saved on your dashboard !';
        } else {
            $user->removePiece($piece);
            $message = 'Critics on "'.$piece.'" unsaved !';
        }
    
        $entityManager->persist($user);
        $entityManager->flush();
        
        return new JsonResponse([
            'success' => true,
            'message' => $message
        ]);
    }

    // > Unsave a critics page
    // #[Route('/critics/{id}/unsave', name: 'unsave_critics')]
    // public function unsaveCritics(Security $security, EntityManagerInterface $entityManager, Piece $piece = null, Request $request)
    // {
    //     $user = $security->getUser();

    //     if (!$user) {
    //         $this->addFlash('crUnSaveFail', 'You must be logged in to unsave a critics page !');
    //         return $this->redirectToRoute('app_login');
    //     }

    //     $user->removePiece($piece);
    
    //     $entityManager->persist($user);
    //     $entityManager->flush();
    
    //     $this->addFlash('crUnSaveSuccess', 'Critics on "'.$piece.'" unsaved ! ');

    //     // > Custom routing from origin page
    //     $origin = $request->query->get('origin');

    //     if ($origin === 'criticsPage' ) {
    //         return $this->redirectToRoute('show_critics', ['id' => $piece->getId()]);
    //     } else {
    //         return $this->redirectToRoute('dashboard_user');
    //     }
    // }

    // // > Like an influencer
    // #[Route('/influencer/{id}/like', name: 'like_influencer')]
    // public function likeInfluencer(Security $security, EntityManagerInterface $entityManager, Influencer $influencer = null)
    // {
    //     $user = $security->getUser();

    //     if (!$user) {
    //         $this->addFlash('inLikeFail', 'You must be logged in to like a content creator !');
    //         return $this->redirectToRoute('app_login');
    //     }

    //     $user->addInfluencer($influencer);

    //     $entityManager->persist($user);
    //     $entityManager->flush();

    //     $this->addFlash('inLikeSuccess', ' "'.$influencer.'" liked !');
    //     return $this->redirectToRoute('show_influencer', ['id' => $influencer->getId()]);
    // }

    // > Like/Unlike an influencer (AJAX ver.)
    #[Route('/influencer/{id}/{action}', name: 'like_influencer', methods: ['POST'])]
    public function saveInfluencer(Security $security, EntityManagerInterface $entityManager, Influencer $influencer = null, Request $request, string $action)
    {
        $user = $security->getUser();

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'You must be logged in to ' . ($action === 'like' ? 'like' : 'unlike') . ' a content creator !'
            ], 401);
        }

        if ($action === 'like') {
            $user->addInfluencer($influencer);
            $message = ' "'.$influencer.'" liked !';
        } else {
            $user->removeInfluencer($influencer);
            $message = ' "'.$influencer.'" unliked !';
        }
    
        $entityManager->persist($user);
        $entityManager->flush();
        
        return new JsonResponse([
            'success' => true,
            'message' => $message,
            'totalLikes' => $influencer->getTotalLikes()
        ]);
    }

    // > Unlike an influencer
    // #[Route('/influencer/{id}/unlike', name: 'unlike_influencer')]
    // public function unlikeInfluencer(Security $security, EntityManagerInterface $entityManager, Influencer $influencer = null, Request $request)
    // {
    //     $user = $security->getUser();

    //     if (!$user) {
    //         $this->addFlash('inUnLikeFail', 'You must be logged in to unlike a content creator !');
    //         return $this->redirectToRoute('app_login');
    //     }

    //     $user->removeInfluencer($influencer);
    
    //     $entityManager->persist($user);
    //     $entityManager->flush();
    
    //     $this->addFlash('inUnLikeSuccess', ' "'.$influencer.'" unliked ! ');

    //     // > Custom routing from origin page
    //     $origin = $request->query->get('origin');

    //     if ($origin === 'influencerPage' ) {
    //         return $this->redirectToRoute('show_influencer', ['id' => $influencer->getId()]);
    //     } else {
    //         return $this->redirectToRoute('dashboard_user');
    //     }
    // }

    // > User's score vote
    #[Route('/piece/{id}/score', name: 'score_piece')]
    public function scorePiece(Security $security, EntityManagerInterface $entityManager, Piece $piece, Request $request, OpinionRepository $opinionRepository, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('scPieceFail', 'You must be logged in to vote !');
            return $this->redirectToRoute('app_login');
        }

        if (isset($_POST["submit"])) {
            $userScore = filter_input(INPUT_POST, "rating", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $existingOpinion = $opinionRepository->findOneBy([
                    'user' => $user,
                    'piece' => $piece
                ]);

            if ($userScore && $userScore >= 1 && $userScore <= 5 && !$existingOpinion) {

                $submittedToken = $request->request->get('_token');
                if (!$csrfTokenManager->isTokenValid(new CsrfToken('rating_add', $submittedToken))) {
                    throw new AccessDeniedHttpException('Invalid CSRF token');
                }

                $opinion = new Opinion();

                $opinion->setUserScore($userScore);
                $opinion->setPiece($piece);
                $opinion->setUser($user);

                $entityManager->persist($opinion);
                $entityManager->flush();

                $this->addFlash('scPieceSuccess', 'Your score on "'.$piece.'" has been set !');
                return $this->redirectToRoute('infos_piece', ['slug' => $piece->getSlug()]);
                    
            } else {
                $this->addFlash('scPieceFail', 'Please set only one score between 1 & 5 !');
                return $this->redirectToRoute('infos_piece', ['slug' => $piece->getSlug()]);
            }
        }
    }

    // > User's score reset
    #[Route('/piece/{piece}/opinion/{opinion}/reset', name: 'score_reset')]
    public function resetScore(Security $security, EntityManagerInterface $entityManager, Piece $piece, Opinion $opinion) {
        
        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('scResetFail', 'You must be logged in to reset score !');
            return $this->redirectToRoute('app_login');
        }

        if ($user->getId() != $opinion->getUser()->getId()) {
            $this->addFlash('scResetFail', 'You do not have the required authorisation !');
            return $this->redirectToRoute('infos_piece', ['slug' => $piece->getSlug()]);
        }

        $entityManager->remove($opinion);
        $entityManager->flush();
        
        $this->addFlash('scResetSuccess', 'Your score on "'.$piece.'" has been reset !');
        return $this->redirectToRoute('infos_piece', ['slug' => $piece->getSlug()]);
    }

    // User's critic like
    #[Route('/critic/{id}/like', name: 'like_critic')]
    public function likeCritic(Security $security, EntityManagerInterface $entityManager, Critic $critic, AgreementRepository $agreementRepository) {

        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('likCriticFail', 'You must be logged in to like a critic !');
            return $this->redirectToRoute('app_login');
        }

        $agreement = $agreementRepository->findOneBy([
            'user' => $user,
            'critic' => $critic
        ]);

        // foreach ($user->getAgreements() as $existingAgreement) {
        //     if ($existingAgreement->getCritic()->getId() === $critic->getId()) {
        //         $agreement = $existingAgreement;
        //     }
        // }

        if ($agreement) {
            if ($agreement->isOk() === true) {
                $entityManager->remove($agreement);
            } else {
                $agreement->setIsOk(true);
                $this->addFlash('likCriticSuccess', 'You liked '.$critic->getInfluencer().'\'s critic on "'.$critic->getPiece().'" !');
            }
        } else {
            $agreement = new Agreement ();
            $agreement->setIsOk(true);
            $agreement->setCritic($critic);
            $agreement->setUser($user);
            $entityManager->persist($agreement);
            $this->addFlash('likCriticSuccess', 'You liked '.$critic->getInfluencer().'\'s critic on "'.$critic->getPiece().'" !');
        }

        $entityManager->flush();

        return $this->redirectToRoute('show_critics', ['slug' => $critic->getPiece()->getSlug()]);
    }

    // User's critic like (AJAX ver.)
    // #[Route('/critic/{id}/like', name: 'like_critic', methods: ['POST'])]
    // public function likeCriticAJAX(Security $security, EntityManagerInterface $entityManager, Critic $critic = null, Agreement $agreement = null, Request $request) 
    // {
    //     $user = $security->getUser();

    //     if (!$user) {
    //         return new JsonResponse([
    //             'success' => false,
    //             'message' => 'You must be logged in to like a critic !'
    //         ], 401);
    //     }

    //     foreach ($user->getAgreements() as $existingAgreement) {
    //         if ($existingAgreement->getCritic()->getId() === $critic->getId()) {
    //             $agreement = $existingAgreement;
    //         }
    //     }

    //     if ($agreement) {
    //         if ($agreement->isOk() === true) {
    //             $entityManager->remove($agreement);
    //         } else {
    //             $agreement->setIsOk(true);
    //             $message = 'You liked '.$critic->getInfluencer().'\'s critic on "'.$critic->getPiece().'" !';
    //         }
    //     } else {
    //         $agreement = new Agreement ();
    //         $agreement->setIsOk(true);
    //         $agreement->setCritic($critic);
    //         $agreement->setUser($user);
    //         $entityManager->persist($agreement);
    //         $message = 'You liked '.$critic->getInfluencer().'\'s critic on "'.$critic->getPiece().'" !';
    //     }

    //     $entityManager->flush();
        
    //     return new JsonResponse([
    //         'success' => true,
    //         'message' => $message
    //     ]);
    // }

    // User's critic dislike
    #[Route('/critic/{id}/dislike', name: 'dislike_critic')]
    public function dislikeCritic(Security $security, EntityManagerInterface $entityManager, Critic $critic = null, AgreementRepository $agreementRepository) {

        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('disCriticFail', 'You must be logged in to dislike a critic !');
            return $this->redirectToRoute('app_login');
        }

        $agreement = $agreementRepository->findOneBy([
            'user' => $user,
            'critic' => $critic
        ]);

        // foreach ($user->getAgreements() as $existingAgreement) {
        //     if ($existingAgreement->getCritic()->getId() === $critic->getId()) {
        //         $agreement = $existingAgreement;
        //     }
        // }

        if ($agreement) {
            if ($agreement->isOk() === false) {
                $entityManager->remove($agreement);
            } else {
                $agreement->setIsOk(false);
                $this->addFlash('disCriticSuccess', 'You disliked '.$critic->getInfluencer().'\'s critic on "'.$critic->getPiece().'" !');
            }
        } else {
            $agreement = new Agreement ();
            $agreement->setIsOk(false);
            $agreement->setCritic($critic);
            $agreement->setUser($user);
            $entityManager->persist($agreement);
            $this->addFlash('disCriticSuccess', 'You disliked '.$critic->getInfluencer().'\'s critic on "'.$critic->getPiece().'" !');
        }

        $entityManager->flush();

        return $this->redirectToRoute('show_critics', ['slug' => $critic->getPiece()->getSlug()]);
    }

    // > User's comment add
    #[Route('/critic/{id}/comment', name: 'comment_critic')]
    public function commentCritic(Security $security, EntityManagerInterface $entityManager, Critic $critic, Request $request, CsrfTokenManagerInterface $csrfTokenManager, 
    PerspectiveApiService $perspectiveApi)
    {
        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('coCriticFail', 'You must be logged in to comment !');
            return $this->redirectToRoute('app_login');
        }

        if (isset($_POST["submit"])) {
            $addComment = ($_POST["addComment"]);

            // > Filter without escaping spec chars
            $addComment = strip_tags($addComment);

            // > Filter language
            $contentAnalyse = $perspectiveApi->analyzeText($addComment);
            $contentResult = $contentAnalyse->isSafe();

            if (empty($addComment) || trim($addComment) == '') {
                $this->addFlash('coCriticFail', 'Your comment is empty !');

            } elseif (strlen($addComment) > 3500) {
                $this->addFlash('coCriticFail', 'Your comment is too long !');

            } elseif (!$contentResult) {
                $this->addFlash('coCriticFail', 'Your comment contains inappropriate content !');

            } else {

                $submittedToken = $request->request->get('_token');
                if (!$csrfTokenManager->isTokenValid(new CsrfToken('comment_add', $submittedToken))) {
                    throw new AccessDeniedHttpException('Invalid CSRF token');
                }

                $comment = new Comment();

                $comment->setText($addComment);
                $comment->setUser($user);
                $comment->setCritic($critic);

                $entityManager->persist($comment);
                $entityManager->flush();

                $this->addFlash('coCriticSuccess', 'Your comment on '.$critic->getInfluencer().'\'s critic has been posted !'); 
            }

            return $this->redirectToRoute('show_critics', ['slug' => $critic->getPiece()->getSlug()]);
        }
    }
    
    // > User's comment delete
    #[Route('/critic/{critic}/comment/{comment}/delete', name: 'comment_delete')]
    public function deleteComment(AuthorizationCheckerInterface $authorizationChecker, Security $security, EntityManagerInterface $entityManager, Critic $critic = null, Comment $comment = null) {
        
        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('coDeleteFail', 'You must be logged in to delete a comment !');
            return $this->redirectToRoute('app_login');
        }

        if ($user->getId() != $comment->getUser()->getId() && !$authorizationChecker->isGranted('ROLE_MODO')) {
            $this->addFlash('coDeleteFail', 'You do not have the required authorisation !');
            return $this->redirectToRoute('app_home');
        }

        $entityManager->remove($comment);
        $entityManager->flush();
        
        $this->addFlash('coDeleteSuccess', 'Comment has been deleted !');
        return $this->redirectToRoute('show_critics', ['slug' => $critic->getPiece()->getSlug()]);
    }

    // > VIP a comment
    #[Route('/critic/{critic}/comment/{comment}/vip', name: 'comment_vip')]
    public function vipComment(AuthorizationCheckerInterface $authorizationChecker, Security $security, EntityManagerInterface $entityManager, Critic $critic = null, Comment $comment = null) {

        $user = $security->getUser();

        if (!$user && !$authorizationChecker->isGranted('ROLE_MODO')) {
            $this->addFlash('vipFail', 'You must be logged in and have the right access to VIP a comment !');
            return $this->redirectToRoute('app_login');
        }

        $currentValue = $comment->isVip();

        if ($currentValue === null) {
            $comment->setIsVip(true);
        } else {
            $comment->setIsVip(!$currentValue);
        }

        $entityManager->flush();

        if ($comment->isVip() === true) {
            $this->addFlash('vipSuccess', 'Comment has been VIPed !');
        } else {
            $this->addFlash('vipSuccess', 'VIPed has been unset !');
        }

        return $this->redirectToRoute('show_critics', ['slug' => $critic->getPiece()->getSlug()]);
    }

    // > Edit User's infos
    #[Route('/user/edit', name: 'edit_user')]
    public function edit(
    Request $request, 
    EntityManagerInterface $entityManager,
    SluggerInterface $slugger,
    CsrfTokenManagerInterface $csrf,
    #[Autowire('%kernel.project_dir%/public/uploads/photos/userPhotos')] string $photosDirectory,
    Security $security,
    PerspectiveApiService $perspectiveApi
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

            $userStatus = $form->get('status')->getData();
            $userBio = $form->get('bio')->getData();
            $contentToCheck = [$userStatus, $userBio];
            
            $photoFile = $form->get('profilePicture')->getData();


            // > If status or bio
            foreach ($contentToCheck as $content) {
                if ($content) {

                // > Filter language
                $contentAnalyse = $perspectiveApi->analyzeText($content);
                $contentResult = $contentAnalyse->isSafe();

                    if (!$contentResult) {
                        $this->addFlash('coCriticFail', 'Your profile contains inappropriate content !');
                        return $this->redirectToRoute('dashboard_user');
                    }
                }
            }
            

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
    public function delete(EntityManagerInterface $entityManager, Security $security, TokenStorageInterface $tokenStorage, CommentRepository $commentRepository, UserRepository $userRepository)
    {
        $user = $security->getUser();

        // > If User is not logged, return to Login page
        if (!$user) {
            $this->addFlash('usDeleteFail', 'You must be logged in to delete your profile !');
            return $this->redirectToRoute('app_login');
        }

        // > Anonymizing user's comments
        $existingComments = $commentRepository->findBy([
            'user' => $user,
        ]);
        $deletedUser = $userRepository->findOneBy([
            'nickName' => 'Deleted User'
        ]);

        foreach ($existingComments as $existingComment) {
            $existingComment->setUser($deletedUser);
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