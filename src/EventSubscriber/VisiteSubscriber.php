<?php

namespace App\EventSubscriber;

use App\Entity\Visite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class VisiteSubscriber implements EventSubscriberInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function onRequestEvent(RequestEvent $event): void
    {
        // On ignore les sous-requêtes (ex: rendu de fragments internes)
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $path = $request->getPathInfo();

        // On exclut l'admin, le login, le profiler et les assets
        $exclusions = ['/admin', '/login', '/logout', '/profil', '/projet', '/competence', '/parcours', '/message', '/_profiler', '/_wdt', '/build', '/assets'];

        foreach ($exclusions as $exclusion) {
            if (str_starts_with($path, $exclusion)) {
                return;
            }
        }

        // On ne trace que les vraies pages (pas les requêtes AJAX/API si tu en ajoutes plus tard)
        if (!$request->isMethod('GET')) {
            return;
        }

        $visite = new Visite();
        $visite->setDateVisite(new \DateTimeImmutable());
        $visite->setAdresseIp($request->getClientIp() ?? 'inconnue');
        $visite->setPageVisitee($path);

        $this->entityManager->persist($visite);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onRequestEvent',
        ];
    }
}