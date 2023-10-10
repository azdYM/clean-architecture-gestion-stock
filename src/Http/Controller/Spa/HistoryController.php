<?php

namespace App\Http\Controller\Spa;

use App\Http\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends BaseController
{
    #[Route('/history', name: 'history')]
    public function history()
    {
        return $this->render('pages/app.html.twig', []);
    }
}