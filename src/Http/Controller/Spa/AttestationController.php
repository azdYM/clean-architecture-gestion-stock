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

    #[Route('/attestations/all', name: 'attestations_all')]
    public function attestationsAll()
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/attestations/waiting', name: 'attestations_waiting')]
    public function attestationsWaiting()
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/attestations/accepted', name: 'attestations_accepted')]
    public function attestationsAccepted()
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/attestations/rejected', name: 'attestations_rejected')]
    public function attestationsRejected()
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/attestations/pawncredit', name: 'attestations_paw_credit')]
    public function attestationsForPawnCredit()
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/attestation/{id<\d+>}', name: 'show_attestation')]
    public function showAttestation(int $id)
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/attestation-update/{id<\d+>}', name: 'update_attestation')]
    public function update(int $id)
    {
        return $this->render('pages/app.html.twig', []);
    }
}