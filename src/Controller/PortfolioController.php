<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParcoursRepository;
use App\Repository\CompetenceRepository;

class PortfolioController extends AbstractController
{
    #[Route('/projets', name: 'app_projets_public')]
    public function projets(Request $request, ProjetRepository $projetRepository): Response
    {
        $categorie = $request->query->get('categorie');

        if ($categorie) {
            $projets = $projetRepository->findBy(['categorie' => $categorie]);
        } else {
            $projets = $projetRepository->findAll();
        }

        return $this->render('portfolio/projets.html.twig', [
            'projets' => $projets,
            'categorieActive' => $categorie,
        ]);
    }

    #[Route('/mon-parcours', name: 'app_parcours_public')]
    public function parcours(ParcoursRepository $parcoursRepository): Response
    {
        $parcours = $parcoursRepository->findBy([], ['dateDebut' => 'DESC']);

        return $this->render('portfolio/parcours.html.twig', [
            'parcours' => $parcours,
        ]);
    }
    #[Route('/a-propos', name: 'app_apropos_public')]
    public function apropos(CompetenceRepository $competenceRepository): Response
    {
        return $this->render('portfolio/apropos.html.twig', [
            'competences' => $competenceRepository->findAll(),
        ]);
    }
    #[Route('/contact', name: 'app_contact_public')]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setDateEnvoi(new \DateTimeImmutable());
            $message->setLu(false);

            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash('success', 'Votre message a bien été envoyé !');

            return $this->redirectToRoute('app_contact_public');
        }

        return $this->render('portfolio/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
