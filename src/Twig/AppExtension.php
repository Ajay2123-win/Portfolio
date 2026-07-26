<?php

namespace App\Twig;

use App\Repository\ProfilRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private ProfilRepository $profilRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('profil_actuel', [$this, 'getProfilActuel']),
        ];
    }

    public function getProfilActuel(): ?\App\Entity\Profil
    {
        return $this->profilRepository->findOneBy([]);
    }
}