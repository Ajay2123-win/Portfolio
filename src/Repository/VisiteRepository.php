<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

public function countTotal(): int
{
    return $this->count([]);
}

public function countUniqueVisitors(): int
{
    return (int) $this->createQueryBuilder('v')
        ->select('COUNT(DISTINCT v.adresseIp)')
        ->getQuery()
        ->getSingleScalarResult();
}

public function countToday(): int
{
    $debut = new \DateTimeImmutable('today');

    return (int) $this->createQueryBuilder('v')
        ->select('COUNT(v.id)')
        ->where('v.dateVisite >= :debut')
        ->setParameter('debut', $debut)
        ->getQuery()
        ->getSingleScalarResult();
}

public function visitesParJour(int $nbJours = 7): array
{
    $debut = new \DateTimeImmutable("-{$nbJours} days");

    $visites = $this->createQueryBuilder('v')
        ->where('v.dateVisite >= :debut')
        ->setParameter('debut', $debut)
        ->getQuery()
        ->getResult();

    $parJour = [];

    foreach ($visites as $visite) {
        $jour = $visite->getDateVisite()->format('Y-m-d');
        if (!isset($parJour[$jour])) {
            $parJour[$jour] = 0;
        }
        $parJour[$jour]++;
    }

    ksort($parJour);

    $resultats = [];
    foreach ($parJour as $jour => $total) {
        $resultats[] = ['jour' => $jour, 'total' => $total];
    }

    return $resultats;
}

public function pagesLesPlusVisitees(int $limite = 5): array
{
    return $this->createQueryBuilder('v')
        ->select('v.pageVisitee, COUNT(v.id) as total')
        ->groupBy('v.pageVisitee')
        ->orderBy('total', 'DESC')
        ->setMaxResults($limite)
        ->getQuery()
        ->getResult();
}
}
