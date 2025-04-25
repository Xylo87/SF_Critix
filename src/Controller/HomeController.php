<?php

namespace App\Controller;

use App\Repository\PieceRepository;
use App\Repository\CategoryRepository;
use App\Repository\InfluencerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(PieceRepository $pieceRepository, InfluencerRepository $influencerRepository)
    {

        $pieces = $pieceRepository->findBy([], ["releaseDate" => "DESC"]);
        $influencers = $influencerRepository->findBy([], ["nickName" => "DESC"]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'pieces' => $pieces,
            'influencers' => $influencers
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function indexAbout()
    {

        return $this->render('home/about.html.twig', [
        ]);
    }

    #[Route('/legal', name: 'app_legal')]
    public function indexLegal()
    {

        return $this->render('home/legal.html.twig', [
        ]);
    }

    #[Route('/privacy', name: 'app_privacy')]
    public function indexPrivacy()
    {

        return $this->render('home/privacy.html.twig', [
        ]);
    }
}
