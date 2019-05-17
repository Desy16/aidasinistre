<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

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
     * Permet d'afficher le formulaire de création
     * 
     * @Route("/actualites/new", name="articles_create")
     * 
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
       $article = new Article();

       $form = $this->createForm(ArticleType::class, $article);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){

           $article->setCreateAt(new \Datetime());

           $manager->persist($article);
           $manager->flush();

           $this->addFlash(
            'success', 
            "Votre article a bien été crée "
        );

           return $this->redirectToRoute('articles_show', ['slug' => $article->getSlug()]);

       }

       return $this->render('article/create.html.twig', [
        'form_article' => $form->createView()
       ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     * 
     * @Route("/actualites/{slug}/edit", name="articles_edit")
     * 
     * @return Response
     */
    public function edit(Article $article, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $article->setCreateAt(new \Datetime());
 
            $manager->persist($article);
            $manager->flush();
 
            $this->addFlash(
             'success', 
             "Les modifications  de l'article <strong>{$article->getTitle()}</strong> ont été bien enregistrées !"
         );

            return $this->redirectToRoute('articles_show', ['slug' => $article->getSlug()]);

        }
        return $this->render('article/edit.html.twig', [
            'form_edit' => $form->createView(),
            'article' =>$article
        ]);
    }

    /**
     * Permet d'afficher un seul article
     * 
     * @Route("/actualites/{slug}", name="articles_show")
     * 
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
