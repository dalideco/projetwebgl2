<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/france', name: 'recipe')]
    public function index(): Response
    {
        return $this->render('Country/France.html.twig',[

        ]);
    }
}
