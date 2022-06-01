<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PersonneController extends AbstractController
{

    /**
     * Ajouter une personne
     */
    #[Route('/personne/add', name: 'personne_add')]
    public function index(EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $personne = new Personne();
        $personne->setNom('Maradonna');
        $personne->setPrenom('Diego');
        $errors = $validator->validate($personne);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        $entityManager->persist($personne);
        $entityManager->flush();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'ajoutée'
        ]);
    }

    /**
     * Effectuer une recherche de toutes les personnes
     */
    #[Route('/personne/show', name: 'personne_show_all')]
    public function showAllPersonne(PersonneRepository $personneRepository): Response
    {
        $personnes = $personneRepository->findAll();

        if (!$personnes) {
            throw $this->createNotFoundException("Aucune donnée trouvée");
        }

        return $this->render('personne/show.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes' => $personnes,
        ]);
    }

    /**
     * Rechercher une personne par l'id
     */
    #[Route('/personne/{id}', name: 'personne_show')]
    public function showPersonneById(int $id, PersonneRepository $personneRepository): Response
    {
        $personne = $personneRepository->find($id);
        if (!$personne) {
            throw $this->createNotFoundException("Personne non trouvée avec l'identifiant $id .");
        }

        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'recherchée'
        ]);
    }

    /**
     * Effectuer une recherche par nom et prenom
     */
    #[Route('/personne/{nom}/{personne}', name: 'personne_show_one')]
    public function showPersonneByNameAndLastName(string $nom, string $prenom, PersonneRepository $personneRepository): Response
    {
        $personne = $personneRepository->findOneBy([
            "nom" => $nom,
            "prenom" => $prenom
        ]);

        if (!$personne) {
            throw $this->createNotFoundException("Personne non trouvée.");
        }

        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'recherchée'
        ]);
    }
}
