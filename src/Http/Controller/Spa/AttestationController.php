<?php

namespace App\Http\Controller\Spa;

use App\Http\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

class AttestationController extends BaseController
{
    #[Route('/attestations', name: 'attestations')]
    public function attestations()
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/attestation/{id<\d+>', name: 'show_attestation')]
    public function showAttestation(int $id)
    {
        return $this->render('pages/app.html.twig', []);
    }
}