<?php

namespace App;

interface ChoiceInterface
{
    const sexe = [
        'Homme' => 1,
        'Femme' => 2,
        'Autres' => 3
    ];

    const roles = [
        'Eleve' => "ROLE_USER",
        'Moniteur' => "ROLE_MONITEUR",
        'MoniteurAndAdmin' => "ROLE_ADMIN"
    ];
}