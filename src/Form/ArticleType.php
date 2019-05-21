<?php

namespace App\Form;

use App\Entity\Article;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Titre de l'article"))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse", "Adresse de l'article"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Introduction de l'article"))
            ->add('content', TextareaType::class, $this->getConfiguration("Contenu", "Contenu de l'article"))
            ->add('coverImage', TextType::class, $this->getConfiguration("Image", "Image de l'article"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
