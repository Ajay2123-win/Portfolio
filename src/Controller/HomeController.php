<?php

namespace App\Controller;

use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProfilRepository $profilRepository): Response
    {
        $profil = $profilRepository->findOneBy([]);

        return $this->render('home/index.html.twig', [
            'profil' => $profil,
        ]);
    }
}