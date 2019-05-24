<?php

namespace App\Controller;

use App\Service\Paginator;
use App\Entity\Association;
use App\Form\AssociationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAssociationController extends AbstractController
{
    /**
     * Permet d'afficher toutes les associations
     * 
     * @Route("/admin/associations/{page<\d+>?1}", name="admin_associations_index")
     */
    public function index($page, Paginator $paginator)
    {
        $paginator->setEntityClass(Association::class)
                  ->setLimit(2)
                  ->setPage($page);

        return $this->render('admin/association/index.html.twig', [
            'paginator' => $paginator
        ]);
    }


    /**
     * Permet d'afficher le formulaire de création d'un association
     * 
     * @Route("/admin/association/new", name="admin_association_create")
     * 
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
       $association = new Association();

       $form = $this->createForm(AssociationType::class, $association);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){

           $manager->persist($association);
           $manager->flush();

           $this->addFlash(
            'success', 
            "Votre association a bien été crée "
        );

           return $this->redirectToRoute('admin_associations_index');

       }

       return $this->render('admin/association/create.html.twig', [
        'form_association' => $form->createView()
       ]);
    }
    

    /**
     * Permet d'afficher le formulaire d'édition d'une association
     * 
     * @Route("/admin/associations/{id}/edit", name="admin_association_edit")
     * 
     */
    public function edit(Association $association, Request $request, ObjectManager $manager)
    {
         
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
 
            $manager->persist($association);
            $manager->flush();
 
            $this->addFlash( 
             'success', 
             "Les modifications  de l'association <strong>{$association->getName()}</strong> ont été bien enregistrées !"
         );

            return $this->redirectToRoute('admin_associations_index');

        }
        return $this->render('admin/association/edit.html.twig', [
            'form_edit' => $form->createView(),
            'association' =>$association
        ]);
    }


     /**
     * Permet de supprimer une association
     * 
     * @Route("/admin/associations/{id}/delete", name="admin_association_delete")
     * 
     * @return Response
     */
    public function delete(Association $association, ObjectManager $manager)
    {
        
        $manager->remove($association);
        $manager->flush();

        $this->addFlash( 
            'warning', 
            "L'association <strong>{$association->getName()}</strong> a bien été supprimé !"
        );

        return $this->redirectToRoute('admin_associations_index');

    }


}
