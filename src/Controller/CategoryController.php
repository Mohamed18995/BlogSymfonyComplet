<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    //afficher des categ
    #[Route('/category', name: 'category')]
    public function index(EntityManagerInterface $entityManager): Response
    {

      $categories = $entityManager->getRepository(Category::class)->findAll();


        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

   //affichage une categ

  /**
    * @Route("/category/{id}", name="afficher_category")
    */
    public function afficher(Category $category) : Response
    {
      return $this->render('category/show.html.twig', [
       'category' => $category,
       ]);
    }
}
