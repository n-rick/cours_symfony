<?php

namespace App\Util;

interface EmailInterface
{
    public function getAMfromNomPrenom(string $nom, string $prenom): string;
}