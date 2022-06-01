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
     * Editer une personne
     */
    #[Route('/personne/edit/{id}', name: 'personne_edit')]
    public function editPersonne(Personne $personne, EntityManagerInterface $em): Response
    {
        // $personne = $em->getRepository(Personne::class)->find($id);
        if (!$personne) {
            throw $this->createNotFoundException("Personne non trouvée");
        }
        $personne->setNom("Costa");
        $em->flush();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'modifiée'
        ]);
    }

    /**
     * Recherche et par nom
     */
    #[Route('/personne/show/{nom}', name: 'personne_show_nom_')]
    public function showPersonneByNom(string $nom, PersonneRepository $personneRepository): Response
    {
        $personnes = $personneRepository->findByNom($nom);
        if (!$personnes) {
            throw $this->createNotFoundException("Aucune correspondance dans la base de données");
        }
        return $this->render('personne/show.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes' => $personnes,
            'adjectif' => 'recherchée'
        ]);
    }

        /**
     * Recherche et par nom et prenom grâce à une fonction dans le PersonneRepository
     */
    #[Route('/personne/show/{nom}/{prenom}', name: 'personne_show_nom_prenom')]
    public function showSomePersonneByNomANdPrenom(string $nom, string $prenom, PersonneRepository $personneRepository): Response
    {
        $personnes = $personneRepository->findByNomAndPrenom($nom, $prenom);
        if (!$personnes) {
            throw $this->createNotFoundException("Aucune correspondance dans la base de données");
        }
        return $this->render('personne/show.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes' => $personnes,
            'adjectif' => 'recherchée'
        ]);
    }

    /**
     * Rechercher une personne par l'id
     */
    #[Route('/personne/{id}', name: 'personne_show')]
    public function showPersonneById(Personne $personne, PersonneRepository $personneRepository): Response
    {
        // $personne = $personneRepository->find($id);
        if (!$personne) {
            throw $this->createNotFoundException("Personne non trouvée");
        }

        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'recherchée'
        ]);
    }

    /**
     * Supprimer une personne
     */
    #[Route('/personne/delete/{id}', name: 'personne_delete')]
    public function deletePersonne(int $id, EntityManagerInterface $em): Response
    {
        $personne = $em->getRepository(Personne::class)->find($id);
        if (!$personne) {
            throw $this->createNotFoundException("Personne non trouvée");
        }
        $em->remove($personne);
        $em->flush();
        $this->addFlash(
            'info',
            'personne supprimée avec succès!'
        );
        return $this->redirectToRoute("personne_show_all");
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
