<?php

namespace App\Service;

class AdresseEmailService
{
    public function getAMfromNomPrenom($nom, $prenom)
    {
        $adresse = $nom . '.' . $prenom . '@symfony.fr';
        return $adresse;
    }
}
