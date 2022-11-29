<?php

namespace App\DataFixtures;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i <50; $i++){
            $category = new Category();
            $category->setTitre("article $i");
            $category->setDescription("Le contenu $i");

            $manager->persist($category);

            for($j=1; $j <=2 ; $j++){
                $article = new Article();
                $article->setTitre("article $j")
                   ->setContenu("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.")
                   ->setDateCreation(new \DateTime())
                   ->setCategory($category);

                $manager->persist($article);
            }
            $manager->flush();
        }
        $manager->flush();
    }
}
