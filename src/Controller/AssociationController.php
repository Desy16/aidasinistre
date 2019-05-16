<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Entity\Association;
use App\Entity\AssociationSearch;
use App\Form\AssociationSearchType;
use App\Notification\ContactNotification;
use App\Repository\AssociationRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AssociationController extends AbstractController
{
    /**
     * Permet d'afficher la liste des associations
     * 
     * @Route("/associations", name="associations_index")
     */
    public function index(AssociationRepository $repo, Request $request)
    {
        $search = new AssociationSearch();

        $form = $this->createForm(AssociationSearchType::class, $search);
        $form->handleRequest($request);

        $repo = $this->getDoctrine()->getRepository(Association::class);

        $assos = $repo->findAll();

        return $this->render('association/index.html.twig', [
            'controller_name' => 'AssociationController',
            'form_recherche' => $form->createView(),
            'assos' => $assos
        ]);
    }
    /**
     * Permet d'afficher une seule association
     * 
     * @Route("/associations/{slug}", name="associations_show")
     */
    public function show(Association $asso, Request $request, ContactNotification $notification, ObjectManager $manager)
    {
        $contact = new Contact();
        $contact->setAssociation($asso);

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);        
        
        if($form->isSubmitted() && $form->isValid()){

            $notification->notify($contact);

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success', 
                "Vos informations ont été bien envoyé à <strong>{$asso->getName()}</strong>"
            );

            return $this->redirectToRoute('associations_index');
        }

        return $this->render('association/show.html.twig', [
            'controller_name' => 'AssociationController',
            'form_contact' => $form->createView(),
            'asso' => $asso
        ]);
    }
}
