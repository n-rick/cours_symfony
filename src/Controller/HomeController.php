<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Service\AdresseEmailService;
use App\Util\EmailInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    // Utiliser les interpolations
    #[Route('/home', name: "home")]
    #[Route('/accueil', name: "accueil", methods: ['GET', 'POST'])]
    public function index3(Request $request): Response
    {
        // $tab = [2, 3, 8];
        $tab = [2, 3, 8, 10, 5, 4, 1, 7];
        $clubs = ['om', 'ol', 'tfc', 'losc', 'psg'];
        $route = $request->get('_route');
        $personne = new Personne();
        $personne->setId(100);
        $personne->setNom("dalton");
        $personne->setPrenom("jack");
        return $this->render('home/index.html.twig', [
            'controller_name' => $route,
            'tableau' => $tab,
            'personne' => $personne,
            'clubs' => $clubs,
        ]);
    }




    // // Attribute = #
    // #[Route('/home/{nom}', name: 'app_home')]
    // public function index(string $nom): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "$nom",
    //     ]);
    // }
    // // Permet de définir une priorité d'ordre
    // #[Route('/home/index', name: 'app_home2', priority: 3)]
    // public function index2(): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "xxx",
    //     ]);
    // }
    // // Générer des paramètre optionnels
    // #[Route('/home/{nom?}', name: 'app_home')]
    // public function index3(?string $nom): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "$nom",
    //     ]);
    // }

    // // Annotation = @
    // /**
    //  * @Route("/home", name="app_home")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

    // // Avec fichier Yaml et php
    // public function index(): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

    // // Paramètre par défaut
    // #[Route('/home/{age}', name: "home_route", defaults: ["nom" => "doe", "prenom" => "john"])]
    // public function index4(int $age, string $nom, string $prenom): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "$age $nom $prenom",
    //     ]);
    // }

    // // Récupération d'un paramètre avec l'objet request
    // #[Route('/home/{nom}/{prenom}')]
    // public function index(Request $request): Response
    // {
    //     $nom = $request->get('nom');
    //     $prenom = $request->get('prenom');
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "$prenom $nom",
    //     ]);
    // }

    // // Récuparation de tous les paramètres : 
    // #[Route('/home/{prenom}/{nom}', name: "home_route")]
    // public function index(Request $request): Response
    // {
    //     $params = $request->get('_route_params');
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => implode(" ", $params),
    //     ]);
    // }

    // // Paramètre hors route : 
    // #[Route('/home')]
    // public function index(Request $request): Response
    // {
    //     $nom = $request->query->get('nom');
    //     $prenom = $request->get('prenom');
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "$prenom, $nom",
    //     ]);
    // }
    // #[Route('/nom/{nom}/prenom/{prenom}')]
    // public function index2(string $nom, string $prenom): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "$prenom, $nom",
    //     ]);
    // }

    // // Request all : 
    // #[Route('/home')]
    // public function index(Request $request): Response
    // {
    //     $params = $request->query->all();
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => implode(" ", $params),
    //     ]);
    // }

    #[Route('/nom/{nom}/prenom/{prenom}')]
    public function index2(string $nom, string $prenom): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => "$prenom $nom",
        ]);
    }
    #[Route('/home/{nom}/{prenom}')]
    public function index(string $nom, string $prenom, EmailInterface $adresseEmailService): Response
    {
        return $this->render('home/service.html.twig', [
            'controller_name' => $adresseEmailService->getAMfromNomPrenom($nom, $prenom),
        ]);
    }

    // // Récupérer le nom de la route:
    // #[Route('/home', name:'home')]
    // #[Route('/accueil', name:'accueil')]
    // public function home(Request $request): Response
    // {
    //     $route = $request->get('_route');
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "$route",
    //     ]);
    // }

    // // Methode HTTP
    // #[Route('/home', name:'home')]
    // #[Route('/accueil', name:'accueil', methods:['GET', 'POST'])]
    // public function home(Request $request): Response
    // {
    //     $route = $request->get('_route');
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "$route",
    //     ]);
    // }
}
