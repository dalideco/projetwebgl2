<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Recipes;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 0; $i < 20; $i++) {
            $recipe = new Recipes();
            $recipe->setTitle('title '.$i);
            $recipe->setReceipt(random_bytes(500));
            $recipe->setUrl('ImagesFood/pic'.(($i%5)+4).'.jpg');
            $recipe->setCountry("france");
            $recipe->setIsSweet(false);
            $user = 2;
            $recipe->setUserId($this->getReference(2));

            $recipe->setIngredients(random_bytes(300));
            
            $manager->persist($recipe);
        }
        $manager->flush();
    }
}
