<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
    private $entityManager;
    public function __construct(ManagerRegistry $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/demande', name: 'demande')]
    public function index(): Response
    {
        $demandes = $this->entityManager->getRepository(Demande::class)->findAll();
       // dd($demandes);
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandes,
        ]);
    }

    #[Route('/demande/creer', name: 'creer_demande')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(DemandeType::class, null);
        $form->handleRequest($request);
        $doctrine =  $this->entityManager->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $dateCreation = new \DateTimeImmutable();
            $demande = new Demande();
            $demande->setTitre($form->get('titre')->getData());
            $demande->setContenu($form->get('contenu')->getData());
            $demande->setStatus($form->get('status')->getData());
            $demande->setDateCreation($dateCreation);
            $doctrine->persist($demande);
            $doctrine->flush();
        }
        return $this->render('demande/creer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
