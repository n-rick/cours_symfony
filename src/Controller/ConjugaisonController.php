<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConjugaisonController extends AbstractController
{
    // Avec une seul action, quelque soit le verbe du premiere groupe, queluqe soit le pronom personnel
    // /present/manger?pronom=je => je mange
    // /futur/manger?pronom=nous => nous mangerons
    // #[Route('/present/{verbe}', name: 'present')]
    // #[Route('/futur/{verbe}', name: 'futur')]
    // public function index(Request $request): Response
    // {
    //     $route = $request->get('_route');
    //     $pronom = $request->query->all();
    //     $verbe = $request->get('verbe');
    //     $base = substr($verbe, 0, strlen($verbe) - 2);
    //     $present = [
    //         'je' => 'e',
    //         'tu' => 'es',
    //         'il' => 'e',
    //         'nous' => 'ons',
    //         'vous' => 'ez',
    //         'elles' => 'ent'
    //     ];
    //     $present_g = [
    //         "je " => "e",
    //         "tu " => "es",
    //         "il/elle/on " => "e",
    //         "nous " => "eons",
    //         "vous " => "ez",
    //         "ils/elles " => "ent",
    //     ];
    //     $present_c = [
    //         "je " => "ce",
    //         "tu " => "ces",
    //         "il/elle/on " => "ce",
    //         "nous " => "çons",
    //         "vous " => "cez",
    //         "ils/elles " => "cent",
    //     ];
    //     $futur = [
    //         'je' => 'erai',
    //         'tu' => 'eras',
    //         'il' => 'era',
    //         'nous' => 'erons',
    //         'vous' => 'erez',
    //         'elles' => 'rent'
    //     ];
    //     if ($route == "present") {
    //         if ($base[-1] == 'c') {
    //             $choice = $present_c;
    //             $base = substr($base, 0, strlen($base) - 1);
    //         } elseif ($base[-1] == 'g') {
    //             $choice = $present_g;
    //         } else {
    //             $choice = $present;
    //         }
    //         foreach ($choice as $pronom => $terminaison) {
    //             $result =  $pronom  ." " . $base . $terminaison;
    //         }
    //     } else if ($route == "futur") {
    //         $choice = $futur;
    //         foreach ($choice as $pronom => $terminaison) {
    //             $result =  $pronom . " " . $base. $terminaison;
    //         }
    //     }
    //     return $this->render('conjugaison/index.html.twig', [
    //         'controller_name' => $result,
    //     ]);
    // }

    // //Correction  :
    #[Route('/present/{verbe}', name: 'present')]
    #[Route('/futur/{verbe}', name: 'futur')]
    public function index(Request $request): Response
    {
        $pronom = $request->get('pronom');
        $verbe = $request->get('verbe');
        $temps = $request->get('_route');

        $present = [
            "je" => "e",
            "tu" => "es",
            "il/elle/on" => "e",
            "nous" => "ons",
            "vous" => "ez",
            "ils/elles" => "ent",
        ];
        $futur = [
            'je' => 'erai',
            'tu' => 'eras',
            'il' => 'era',
            'nous' => 'erons',
            'vous' => 'erez',
            'elles' => 'rent'
        ];
        $base = substr($verbe, 0, strlen($verbe) - 2);

        return $this->render('conjugaison/index.html.twig', [
            'controller_name' => "$pronom $base" . ($temps == "present" ? $present[$pronom] : $futur[$pronom]),
        ]);
    }
}
