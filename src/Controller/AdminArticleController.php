<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminArticleController extends AbstractController
{
    /**
     * Permet d'afficher tous les articles
     * 
     * @Route("/admin/articles", name="admin_articles_index")
     * 
     */
    public function index(ArticleRepository $repo)
    {
        return $this->render('admin/article/index.html.twig', [
            'articles' => $repo->findAll()

        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     * 
     * @Route("/admin/articles/{id}/edit", name="admin_articles_edit")
     * 
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

            return $this->redirectToRoute('admin_articles_index');

        }
        return $this->render('admin/article/edit.html.twig', [
            'form_edit' => $form->createView(),
            'article' =>$article
        ]);
    }

    /**
     * Permet de supprimer un article
     * 
     * @Route("/admin/articles/{id}/delete", name="admin_articles_delete")
     * 
     * @return Response
     */
    public function delete(Article $article, ObjectManager $manager)
    {
        
        $manager->remove($article);
        $manager->flush();

        $this->addFlash( 
            'warning', 
            "L'article <strong>{$article->getTitle()}</strong> a bien été supprimé !"
        );

        return $this->redirectToRoute('admin_articles_index');

    }

}
