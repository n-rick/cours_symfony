<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{

    #[Route('/personne/add', name: 'personne_add')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $personne = new Personne();
        $personne->setNom('Maradonna');
        $personne->setPrenom('Diego');
        $entityManager->persist($personne);
        $entityManager->flush();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'ajoutée'
        ]);
    }
}
