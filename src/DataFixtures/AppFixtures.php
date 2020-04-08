<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = $faker = Faker\Factory::create('fr_FR');

        $categories = [];
    
        for ($i = 0; $i < 10; $i++) {
          $category = new Categorie();
          $category->setNom($faker->word());
    
          $manager->persist($category);
          $categories[] = $category;
        }
    
        for ($j = 0; $j < 70; $j++) {
          $produit = new Produit();
          $produit->setNom($faker->words(1, true))
            ->setDescription($faker->sentences(5, true))
            ->setPrix($faker->randomFloat($nbMaxDecimals = 2, $min = 0.1, $max = 1000))
            ->addCategory($categories[$faker->numberBetween(0, count($categories) - 1)]);
    
          $manager->persist($produit);
        }
    
        $manager->flush();
    }
}
