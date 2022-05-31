<?php

namespace App\Service;

use App\Util\EmailInterface;
use Psr\Log\LoggerInterface;


class AdresseEmailM2iService implements EmailInterface
{

    // injection de dépendance par constructeur (Comme Angular)
    public function __construct(private LoggerInterface $logger, private string $extension)
    {
    }

    public function getAMfromNomPrenom(string $nom, string $prenom): string
    {
        $adresse = $nom . '.' . $prenom . "@m2i.$this->extension";
        $this->logger->info(" l'adresse : $adresse a été générée");
        return $adresse;
    }
}
