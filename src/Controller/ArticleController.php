<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleType;


class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        $tableau = [5, 7, 9, 12, 188, 220];
           
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController', 'tableau' => $tableau,
        ]);
    }

   
  //  ● Créer une nouvelle route pour sauver un article
  //  – Créer un objet Article que vous persistez en base de données
  //  – A chaque appel de cette route un nouvel article devra être sauvegardé en base de données

    #[Route('/article/new/1', name: 'newArticle')]
    public function new(EntityManagerInterface $entityManager): Response
 {
    $article = new Article();

    $article->setTitre('Mon article');
    $article->setContenu('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
    $article->setDateCreation(new \DateTime());

    $entityManager->persist($article);
    $entityManager->flush();

    return $this->render('article/new.html.twig', [
    'article' => $article,
    ]);
    }

    
    #[Route('/article_1', name: 'article_article_1')]
    public function article_1(){
    return $this->render('article/article_1.html.twig');
    }
    #[Route('/article_2', name: 'article_article_2')]
    public function article_2(){
    return $this->render('article/article_2.html.twig');
    }
    #[Route('/article_3', name: 'article_article_3')]
    public function article_3(){
    return $this->render('article/article_3.html.twig');
    }
    

    // création d'articles pour l'exercice en ajoutant des dates différentes et le mot "magique"
    /**
   * @Route("/article/new/2", name="newArticle2")
   */
  public function new2(EntityManagerInterface $entityManager): Response
  {
    $article1 = new Article();
    $article2 = new Article();
    $article3 = new Article();

    $article1->setTitre('Article 2015');
    $article1->setContenu('
      Lorem ipsum dolor sit magique, consectetur adipiscing elit. Nullam hendrerit ante ut quam ultrices, quis tempor felis vehicula. Nulla viverra ullamcorper sapien at auctor. Fusce sed nisl sodales, faucibus nisi vel, scelerisque mauris. Suspendisse volutpat lectus a elit varius dapibus. Quisque a ligula in ante porttitor bibendum in sit amet purus. Nulla maximus, lacus non suscipit efficitur, risus ante porttitor magna, a iaculis felis ligula mollis nulla. Curabitur blandit mattis metus et blandit. Integer aliquam commodo elit, quis gravida velit dignissim eu. In porttitor venenatis nisl, non ultricies felis rhoncus ut. Aliquam tellus lectus, condimentum eu neque quis, ultrices rutrum libero. Pellentesque in nulla dapibus, porta metus ut, euismod eros. Nulla rhoncus feugiat imperdiet. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan sodales mattis. Aliquam venenatis, risus sed tempus dictum, quam lorem maximus sem, ac elementum enim odio et felis.
    ');
    $article1->setDateCreation(new \DateTime("2015-03-14 00:00"));
    $entityManager->persist($article1);

    $article2->setTitre('Article 2018');
    $article2->setContenu('
      
    ');
    $article2->setDateCreation(new \DateTime("2018-03-14 00:00"));
    $entityManager->persist($article2);


    $article3->setTitre('Article 2021');
    $article3->setContenu('
      Lorem ipsum dolor sit magique, consectetur adipiscing elit. Nullam hendrerit ante ut quam ultrices, quis tempor felis vehicula. Nulla viverra ullamcorper sapien at auctor. Fusce sed nisl sodales, faucibus nisi vel, scelerisque mauris. Suspendisse volutpat lectus a elit varius dapibus. Quisque a ligula in ante porttitor bibendum in sit amet purus. Nulla maximus, lacus non suscipit efficitur, risus ante porttitor magna, a iaculis felis ligula mollis nulla. Curabitur blandit mattis metus et blandit. Integer aliquam commodo elit, quis gravida velit dignissim eu. In porttitor venenatis nisl, non ultricies felis rhoncus ut. Aliquam tellus lectus, condimentum eu neque quis, ultrices rutrum libero. Pellentesque in nulla dapibus, porta metus ut, euismod eros. Nulla rhoncus feugiat imperdiet. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan sodales mattis. Aliquam venenatis, risus sed tempus dictum, quam lorem maximus sem, ac elementum enim odio et felis.
    ');
    $article3->setDateCreation(new \DateTime("2021-08-20 00:00"));
    $entityManager->persist($article3);

    $entityManager->flush();


    return $this->render('article/new.html.twig', [
        'article' => $article1,
    ]);



  }

/**
   * @Route("/titres", name="showArticles")
   */
  public function getAllArticles(EntityManagerInterface $entityManager){
    $repository = $entityManager->getRepository(Article::class);
    $articles = $repository->findAll();

    return $this->render('article/ShowAllArticles.html.twig', [
        'articles' => $articles,
    ]);
  }


  // récupérer un article via son id
    /**
    * @Route("/article/afficher/{id}", name="afficher_article")
    */
    public function afficher(Article $article) : Response
    {
      return $this->render('article/ShowOneArticle.html.twig', [
       'article' => $article,
       ]);
    }

  /**
   * @Route("/search/content", name="showByContenu")
     */
    public function showByContenu(EntityManagerInterface $entityManager): Response
    {
      $repository = $entityManager->getRepository(Article::class);
      $articles = $repository->findByContenu();

        return $this->render('article/ShowContenuMagique.html.twig', [
            'articles' => $articles,
        ]);
    }



  // afficher les articles d'une année passé en paramètre a la route
  /**
   * @Route("/articles/{year}", name="showByYear")
   */
  public function showByYear($year, EntityManagerInterface $entityManager): Response
  {
    $dateTime = new \DateTime();
    $dateTime->setDate($year, "01", "01");
    $repository = $entityManager->getRepository(Article::class);
    $articles = $repository->findByYear($dateTime);

      return $this->render('article/ShowYearTitres.html.twig', [
          'articles' => $articles,
      ]);
  }

  /**
 * @Route("/article/{id}/voter", name="article_vote", methods="POST")
 */
 public function articleVote(Article $article, Request $request)
 {
  $direction = $request->request->get('direction');
// afficher l'article et le contenu de a requête
 dd($article, $request->request->all());
}

  // vote pour un article, retour en JSON pour une fonction ajax
   /**
   * @Route("/article/{id}/voter", name="article_vote", methods="POST")
   */
  public function commentVote($id, $direction)
  {
      if ($direction === 'up') {
          $currentVoteCount = rand(7, 100);
      } else {
          $currentVoteCount = rand(0, 5);
      }

      return $this->json(['votes' => $currentVoteCount]);
  }



}