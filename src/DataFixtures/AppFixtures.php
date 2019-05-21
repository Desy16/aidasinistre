<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Association;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
        
    public function load(ObjectManager $manager)
    {   
        $faker = Factory::create('FR-fr');

        //Création d'un role
        $adminRole = new Role();

        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        //Création d'un administrateur
        $adminUser = new User();

        $adminUser->setFirstName('desty')
                  ->setLastName('mpassi')
                  ->setEmail('desty@aidasinistre.com')
                  ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                  ->addUserRole($adminRole);
        
        $manager->persist($adminUser);

        //Tableau des users vides
        $users = [];
         
        //Nous gérons les utilisateurs
        for($i = 1; $i <= 8; $i++)
        {
            $user = new User();

            $hash = $this->encoder->encodePassword($user, 'password');

           $user->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setHash($hash);

            $manager->persist($user);
            $users[] = $user;
        }

       
       
        

        //Nous gérons les articles
        for($i = 1; $i <= 10; $i++)
        {
            $article = new Article();

            $title = $faker->sentence();
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
            $coverImage = $faker->imageUrl(1000, 350);
            $introduction = $faker->sentence(20);

            //Choix d'un nombre aléatoire pour les users
            $user = $users[mt_rand(0, count($users) - 1)];

            $article->setTitle($title)
                    ->setContent($content)
                    ->setCoverImage($coverImage)
                    ->setCreateAt(new \DateTime())
                    ->setIntroduction($introduction)
                    ->setAuthor($user);
    
            $manager->persist($article);

            $assos = new Association();

            $name = $faker->sentence(8);
            $city = $faker->city();
            $address = $faker->address();
            $postalCode = $faker->postcode();
            $phone = $faker->e164PhoneNumber();

            $assos->setName($name)
                  ->setCity($city)
                  ->setAddress($address)
                  ->setPostalCode($postalCode)
                  ->setPhone($phone);

            $manager->persist($assos);
        }

        $manager->flush();
    }
}
