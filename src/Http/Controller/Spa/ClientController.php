<?php

namespace App\Http\Controller\Spa;

use App\Http\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends BaseController
{
    #[Route('/add-client', name: 'add_client')]
    public function addClient()
    {
        return $this->render('pages/app.html.twig', []);
    }

    #[Route('/client/{folio<\d+>}',  name: 'show_client')]
    public function showClient(int $folio)
    {
        return $this->render('pages/app.html.twig', []);
    }
}