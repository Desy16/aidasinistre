<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminArticleController extends AbstractController
{
    /**
     * @Route("/admin/articles", name="admin_articles_index")
     */
    public function index(ArticleRepository $repo)
    {
        return $this->render('admin/article/index.html.twig', [
            'articles' => $repo->findAll()

        ]);
    }
}
