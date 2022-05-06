<?php

namespace App\Controller;

use DivisionByZeroError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculController extends AbstractController
{
    // calcul/max?marque1=peugeot&marque2=ford => peugeot
    #[Route('/calcul/max')]
    public function max(Request $request)
    {
        $params = $request->query->all();
        $marque = "";
        foreach ($params as $param) {
            if (strlen($param) > strlen($marque))
                $marque = $param;
        };

        return $this->render('calcul/index.html.twig', [
            'controller_name' => $marque,
        ]);
    }


    // définir une méthode calcul/plus?valeur1=2&valeur2=3 => 5
    // définir une méthode calcul/moins?valeur1=2&valeur2=3 => -1
    // une seule actionpour les 4 opération arithmétique
    #[Route('/calcul/{op}')]
    public function calcul(Request $request): Response
    {
        $op = $request->get('op');
        $params = $request->query->all();
        $tab = [
            "plus" => '+',
            "moins" => '-',
            "fois" => "*",
            "div" => '/'
        ];
        $expression = implode($tab[$op], $params);
        $expression .= ";";
        $resultat = "";
        eval('$resultat' . "=" . $expression);

        return $this->render('calcul/index.html.twig', [
            'controller_name' => $expression . "=" . $resultat,
        ]);
    }

    #[Route('/calcul/{val1?}/{op?}/{val2?}', name: 'app_calcul')]
    public function index(?int $val1, ?string $op, ?int $val2): Response
    {
        switch ($op) {
            case 'plus':
                $result = $val1 + $val2;
                break;
            case 'moins':
                $result = $val1 - $val2;
                break;
            case 'fois':
                $result = $val1 * $val2;
                break;
            case 'div':
                if ($val2 == 0) {
                    $result = throw new DivisionByZeroError('impossible');
                }
                $result = $val1 / $val2;
                break;
        }
        return $this->render('calcul/index.html.twig', [
            'controller_name' => $result,
        ]);
    }

    #[Route('/calcul/moyenne/{valeur1}/{valeur2}/{valeur3?}/{valeur4?}/{valeur5?}', name: 'app_moyenne')]
    public function moyenne(Request $request): Response
    {
        $result = 0;
        $nbr = 0;
        $params = $request->get('_route_params');
        foreach ($params as $param) {
            if ($param != null) {
                $result += $param;
                $nbr++;
            }
        }
        return $this->render('calcul/index.html.twig', [
            'controller_name' => $result / $nbr,
        ]);
    }
}
