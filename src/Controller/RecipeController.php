<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Recipes;
use App\Entity\User;

class RecipeController extends AbstractController
{
    #[Route('/france', name: 'france')]
    public function index(): Response
    {

        $repo = $this->getDoctrine()->getRepository(Recipes::class);

        $spicy = $repo->findBy(["country"=>"france","isSweet"=>false]);
        $sweet = $repo->findBy(["country"=>"france","isSweet"=>true]);

        return $this->render('country/France.html.twig',[
                'spicy' =>$spicy,
                'sweet' => $sweet
        ]);
    }

    #[Route("/autoupdate",name:"autoupdate")]
    public function autoupdate(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(User::class);
        $admin = $repo->find(2);

        for ($i = 0; $i < 20; $i++) {
            $recipe = new Recipes();
            $recipe->setTitle('title '.$i);
            $recipe->setReceipt("this is a receipt");
            $recipe->setUrl('ImagesFood/pic'.(($i%5)+4).'.jpg');
            $recipe->setCountry("france");
            $recipe->setIsSweet(true);
            $recipe->setUserId($admin);



            $recipe->setIngredients("these are the ingredients");
            
            $manager->persist($recipe);
        }
        $manager->flush();

        return $this->redirectToRoute('france');

    }
}
