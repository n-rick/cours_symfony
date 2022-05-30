<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    #[Route('/twig/{nom}/{prenom}', name: 'app_twig')]
    public function index(Request $request): Response
    {
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        return $this->render('twig/index.html.twig', [
            'controller_name' => "TwigController",
            'nom' => "$nom",
            'prenom' => "$prenom",
        ]);
    }
    // exo1 définir un route qui prend les steps
    #[Route('/twig/{min}/{max}/{step}', name: 'app_twig_range')]
    public function index2(Request $request): Response
    {
        $min = $request->get('min');
        $max = $request->get('max');
        $step = $request->get('step');
        return $this->render('twig/index.html.twig', [
            'controller_name' => "TwigController",
            'min' => "$min",
            'max' => "$max",
            'step' => "$step",
        ]);
    }

}
