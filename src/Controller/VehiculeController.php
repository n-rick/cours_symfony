<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeController extends AbstractController
{
    // pour une redirection on génère une URL puis on redirige
    // #[Route('/vehicule', name: 'app_vehicule')]
    // public function index(): Response
    // {
    //     $url = $this->generateUrl('app_home_index', [
    //         'nom' => 'Doe',
    //         'prenom' => 'John',
    //     ]);
    //     //     return $this->forward( # redirige sans changer la route
    //     //         'App\Controller\HomeController::index',
    //     //         [
    //     //             'nom' => 'Doe',
    //     //             'prenom' => 'John',
    //     //         ]
    //     //     );
    //     // return new RedirectResponse(($url));
    //     // return $this->redirect($url); #pour utilisé le redicte de AbstractController
    //     return $this->redirectToRoute('app_home_index', [
    //         'nom' => 'Doe',
    //         'prenom' => 'John',
    //     ]); # redirectToRoute
    // }

    // /vehicule/home => une action de HomeController
    // /vehicule/conjugaison => une action de ConjugaisonController
    // /vehicule/calcule => action de CalculController
    #[Route('/vehicule/{route}')]
    public function index(string $route): Response
    {
        switch ($route) {
            case 'home':
                return $this->redirectToRoute('app_home_index', [
                    'nom' => 'Doe',
                    'prenom' => 'John',
                ]);
                break;
            case 'conjugaison':
                return $this->redirectToRoute('present', [
                    'verbe' => 'manger',
                    'pronom' => 'nous',
                ]);
                break;
            case 'calcul':
                return $this->redirectToRoute('app_calcul', [
                    'val1' => 12,
                    'op' => 'plus',
                    'val2' => 14,
                ]);
            default:
                // throw new HttpException(404, 'Page demandée inexistante!'); # pour la gestion d'erreur
                // throw $this->createNotFoundException('Page demandée inexistant!'); # pour la création personnalisé
                // throw new HttpException(418, "oups, ça ne marche pas!");
                throw $this->createAccessDeniedException("oups, ça ne marche pas!");
        }
    }
}
