<?php

namespace App\Controller;

use DivisionByZeroError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculController extends AbstractController
{
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
}
