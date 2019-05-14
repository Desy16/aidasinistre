<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        $faker = Factory::create('FR-fr');
         

        for($i = 1; $i <= 30; $i++)
        {
            $article = new Article();

            $title = $faker->sentence();
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
            $coverImage = $faker->imageUrl(1000, 350);
            $introduction = $faker->sentence(20);

            $article->setTitle($title)
                    ->setContent($content)
                    ->setCoverImage($coverImage)
                    ->setCreateAt(new \DateTime())
                    ->setIntroduction($introduction);
    
            $manager->persist($article);
        }

        $manager->flush();
    }
}
