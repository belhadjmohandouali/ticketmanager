<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(ManagerRegistry $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user= new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);
        $doctrine = $this->entityManager->getManager();

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $password = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $doctrine->persist($user);
            $doctrine->flush();
        }
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
