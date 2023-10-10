<?php

namespace App\Http\Controller\Spa;

use App\Http\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends BaseController
{
    #[Route('/add-credit', name: 'add_credit')]
    public function createCredit()
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/credit/{id<\d+>}', name: 'show_credit')]
    public function showCredit(int $id)
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/credits', name: 'credit')]
    public function credits()
    {
        return $this->render('pages/app.html.twig', []);
    }
}