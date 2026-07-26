<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use App\Repository\ProjetRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_dashboard')]
    public function index(
        VisiteRepository $visiteRepository,
        ProjetRepository $projetRepository,
        MessageRepository $messageRepository
    ): Response {
        return $this->render('dashboard/index.html.twig', [
            'totalVisites' => $visiteRepository->countTotal(),
            'visiteursUniques' => $visiteRepository->countUniqueVisitors(),
            'visitesAujourdhui' => $visiteRepository->countToday(),
            'visitesParJour' => $visiteRepository->visitesParJour(7),
            'pagesPopulaires' => $visiteRepository->pagesLesPlusVisitees(5),
            'nbProjets' => count($projetRepository->findAll()),
            'nbMessagesNonLus' => count($messageRepository->findBy(['lu' => false])),
        ]);
    }
}