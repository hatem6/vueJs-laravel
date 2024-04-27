<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        'api/singupEtudiant',
        'api/signupEntreprise',
        'api/admin',
        'api/login',
        'api/modifyStudent',
        'api/modifyEntreprise',
        'api/getStudentDetail/{id}',
        'api/updateSatutDemande/{id}',
        'api/addDemande',
        'api/deleteDemande/{id}',
        'api/getDemandes/{idEtudiant}',
        'api/getDemandeById/{id}',
        'api/Demandes',
        'api/addOffre',
        'api/getEntreprise/{idEntreprise}',
        'api/getOffres/{idEntreprise}',
        'api/offreDetail/{idEntreprise}/{id}',
        'api/offreDetail2/{id}',
        'api/updateOffre',
        'api/deleteOffre',
        
    ];
}
