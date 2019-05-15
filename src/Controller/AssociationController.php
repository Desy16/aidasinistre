<?php

namespace App\Controller;

use App\Entity\Association;
use App\Repository\AssociationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AssociationController extends AbstractController
{
    /**
     * Permet d'afficher la liste des associations
     * 
     * @Route("/associations", name="associations_index")
     */
    public function index(AssociationRepository $repo)
    {
        $repo = $this->getDoctrine()->getRepository(Association::class);

        $assos = $repo->findAll();

        return $this->render('association/index.html.twig', [
            'controller_name' => 'AssociationController',
            'assos' => $assos
        ]);
    }
    /**
     * Permet d'afficher une seule association
     * 
     * @Route("/associations/{slug}", name="associations_show")
     */
    public function show(Association $asso)
    {

        return $this->render('association/show.html.twig', [
            'controller_name' => 'AssociationController',
            'asso' => $asso
        ]);
    }
}
