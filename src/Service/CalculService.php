<?php

namespace App\Service;

use DivisionByZeroError;

class CalculService
{
    public function getResultat(int $val1, string $op, int $val2)
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
                    $result = throw new DivisionByZeroError('opération impossible');
                }
                $result = $val1 / $val2;
                break;
                default :
                $result = "opérateur inconnu";
        }
        return $result;
    }
}
