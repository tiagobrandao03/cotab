<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagueController extends AbstractController
{
    #[Route('/pague', name: 'app_pague')]
    public function index(): Response
    {
        return $this->render('pague/index.html.twig', [
            'controller_name' => 'PagueController',
        ]);
    }
}
