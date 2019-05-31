<?php

namespace App\Form;

use App\Entity\Association;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AssociationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("Nom", "Nom de l'association"))
            ->add('address', TextType::class, $this->getConfiguration("Adresse", "Adresse de l'association"))
            ->add('postalCode', TextType::class, $this->getConfiguration("Code postal ", "Code postal de l'association"))
            ->add('city', TextType::class, $this->getConfiguration("Ville", "Villle de l'association"))
            ->add('phone', TextType::class, $this->getConfiguration("Téléphone", "Téléphone de l'association"))
            ->add('email', TextType::class, $this->getConfiguration("Email", "Email de l'association"));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
}
