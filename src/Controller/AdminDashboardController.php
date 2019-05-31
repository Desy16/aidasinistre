<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(ObjectManager $manager)
    {
        $users = $manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
        $articles = $manager->createQuery('SELECT COUNT(a) FROM App\Entity\Article a')->getSingleScalarResult();
        $associations = $manager->createQuery('SELECT COUNT(asso) FROM App\Entity\Association asso')->getSingleScalarResult();
        $contacts = $manager->createQuery('SELECT COUNT(cont) FROM App\Entity\Contact cont')->getSingleScalarResult();

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('users', 'articles', 'associations', 'contacts')
        ]);
    }
}
