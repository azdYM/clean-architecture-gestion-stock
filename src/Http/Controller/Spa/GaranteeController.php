<?php

namespace App\Http\Controller\Spa;

use App\Http\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

class GaranteeController extends BaseController
{
    #[Route('/evaluate-gold', name: 'evaluate_gold')]
    public function evaluateGold()
    {
        return $this->render('pages/app.html.twig', []);
    }
}