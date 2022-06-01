<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Personne;
use App\Entity\Sport;
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

    //     /**
    //  * Ajouter une adresse et l'affecté à une personne
    //  */
    // #[Route('/personne/adresse/add', name: 'personne_adresse')]
    // public function addresse(EntityManagerInterface $entityManager): Response
    // {
    //     $adresse = new Adresse();
    //     $adresse->setRue('jean moulin');
    //     $adresse->setCodePostal("13090");
    //     $adresse->setVille("Aix-En-Provence");
    //     $personne = new Personne();
    //     $personne->setNom('Henry');
    //     $personne->setPrenom('Thierry');
    //     $personne->setAdresse($adresse);

    //     $entityManager->persist($personne);
    //     $entityManager->flush();
    //     return $this->render('personne/index.html.twig', [
    //         'controller_name' => 'PersonneController',
    //         'personne' => $personne,
    //         'adjectif' => 'ajoutée avec Adresse'
    //     ]);
    // }

    /**
     * Ajouter ManyToOne adresse et l'affecté à une personne
     */
    #[Route('/personne/sport/add', name: 'personne_sport_add')]
    public function addSport(EntityManagerInterface $entityManager): Response
    {
        $sport = new Sport();
        $sport->setName('Football');
        $sport2 = new Sport();
        $sport2->setName('Tennis');
        $personne = new Personne();
        $personne->setNom('Dalton');
        $personne->setPrenom('Jack');
        $personne->addSport($sport);
        $personne->addSport($sport2);
        $personne2 = new Personne();
        $personne2->setNom('Benamar');
        $personne2->setPrenom('Karim');
        $personne2->addSport($sport);
        $entityManager->persist($personne);
        $entityManager->persist($personne2);
        $entityManager->flush();

        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'ajoutée avec un sport'
        ]);
    }

    /**
     * Ajouter ManyToOne adresse et l'affecté à une personne
     */
    #[Route('/personne/adresse/add', name: 'personne_adresse')]
    public function addresse(EntityManagerInterface $entityManager): Response
    {
        // Relation bidirectionnelle :
        $personne = new Personne();
        $personne->setNom('Wick');
        $personne->setPrenom('John');
        $adresse = new Adresse();
        $adresse->setRue('10 rue de Lyon');
        $adresse->setVille('Marseille');
        $adresse->setCodePostal(13015);
        $adresse->addPersonne($personne);
        dd($personne->getAdresse());

        // $adresse = new Adresse();
        // $adresse->setRue('défense');
        // $adresse->setVille('Paris');
        // $adresse->setCodePostal('75000');
        // $personne = new Personne();
        // $personne->setNom('Cohen');
        // $personne->setPrenom('Sophie');
        // $personne->setAdresse($adresse);
        // $personne2 = new Personne();
        // $personne2->setNom('Wolf');
        // $personne2->setPrenom('Bob');
        // $personne2->setAdresse($adresse);
        // $entityManager->persist($personne);
        // $entityManager->persist($personne2);
        // $entityManager->flush();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'ajoutée avec Adresse'
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
