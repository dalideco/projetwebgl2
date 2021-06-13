<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Form\RecipesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddComposerController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function index(EntityManagerInterface $manager, HttpFoundationRequest $request): Response
    {
        $recipe = new Recipes();
        $form = $this -> createForm(RecipesType::class, $recipe);
        $form -> handleRequest($request);
    if ($form->isSubmitted()){
        $manager-> persist($recipe);
        $manager -> flush();
    }

        return $this->render('add.html.twig', [
            'controller_name' => 'AddController',
            'form' => $form->createView()
        ]);
    }
}