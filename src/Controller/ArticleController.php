<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * Permet d'afficher la liste des articles donc l'actualité
     * 
     * @Route("/actualites", name="articles_index")
     */
    public function index(ArticleRepository $repo)
    {
       /*  $repo = $this->getDoctrine()->getRepository(Article::class); */

        $articles = $repo->findAll();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }

    /**
     * Permet d'afficher un seul article
     * 
     * @Route("/actualites/{slug}", name="articles_show")
     * @return Response
     */
     public function show($slug, ArticleRepository $repo)
     {
         //Je récupère l'article qui correspond au slug
        $article = $repo->findOneBySlug($slug);

        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);

     }
}
