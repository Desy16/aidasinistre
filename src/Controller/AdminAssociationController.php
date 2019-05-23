<?php

namespace App\Controller;

use App\Service\Paginator;
use App\Repository\AssociationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Association;

class AdminAssociationController extends AbstractController
{
    /**
     * Permet d'afficher toutes les associations
     * 
     * @Route("/admin/associations/{page<\d+>?1}", name="admin_associations_index")
     */
    public function index(AssociationRepository $repo, $page, Paginator $paginator)
    {
        $paginator->setEntityClass(Association::class)
                  ->setLimit(2)
                  ->setPage($page);

        return $this->render('admin/association/index.html.twig', [
            'paginator' => $paginator
        ]);
    }

}
