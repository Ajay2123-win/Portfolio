<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateVisite = null;

    #[ORM\Column(length: 50)]
    private ?string $adresseIp = null;

    #[ORM\Column(length: 255)]
    private ?string $pageVisitee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVisite(): ?\DateTimeImmutable
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeImmutable $dateVisite): static
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getAdresseIp(): ?string
    {
        return $this->adresseIp;
    }

    public function setAdresseIp(string $adresseIp): static
    {
        $this->adresseIp = $adresseIp;

        return $this;
    }

    public function getPageVisitee(): ?string
    {
        return $this->pageVisitee;
    }

    public function setPageVisitee(string $pageVisitee): static
    {
        $this->pageVisitee = $pageVisitee;

        return $this;
    }
}
