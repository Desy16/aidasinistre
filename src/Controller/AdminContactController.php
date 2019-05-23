<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Service\Paginator;
use App\Repository\ContactRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminContactController extends AbstractController
{
    /**
     * Permet d'afficher tous les contacts du site
     * 
     * @Route("/admin/contacts/{page<\d+>?1}", name="admin_contacts_index")
     */
    public function index(ContactRepository $repo, $page, Paginator $paginator)
    {
        $paginator->setEntityClass(Contact::class)
                  ->setLimit(2)
                  ->setPage($page);

        return $this->render('admin/contact/index.html.twig', [
            'paginator' => $paginator
        ]);
    }

    
    /**
     * Permet de supprimer un contact
     * 
     * @Route("/admin/contacts/{id}/delete", name="admin_contact_delete")
     * 
     * @return Response
     */
    public function delete(Contact $contact, ObjectManager $manager)
    {
        
        $manager->remove($contact);
        $manager->flush();

        $this->addFlash( 
            'warning', 
            "Le contact <strong>{$contact->getLastName()}</strong> a bien été supprimé !"
        );

        return $this->redirectToRoute('admin_contacts_index');

    }
}
