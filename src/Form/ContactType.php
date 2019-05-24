<?php

namespace App\Form;

use App\Entity\Contact;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "BRACQUART"))
            ->add('firstName', TextType::class, $this->getConfiguration("Prenom", "Remi"))
            ->add('phone', TextType::class, $this->getConfiguration("Telephone", "0780845716"))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "vous@aidasinistre.com"))
            ->add('message', TextareaType::class, $this->getConfiguration("Message", "Ex...."))
            ->add('qualification', ChoiceType::class, $this->getConfigurationQualif())
            ->add('sinister', ChoiceType::class, $this->getConfigurationSinistre())
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }


    /**
     * Permet la configuration du champ Sinistre !
     * 
     */
    private function getConfigurationSinistre()
    {
       return
       [
            'choices' => [

               '--Veuillez choisir un sinistre--' => 'null',

                'Evenements climatiques' => [
                   'Tempête' => 'tempete',
                   'Inondation' => 'inondation',
                   'Grêle' => 'grele',
                   'Neige' => 'neige'
                ],

                   'Incendie' => 'incendie',
                   'Vol' => 'vol',
                   'Degâts des eaux' => 'degats_eaux',
                   'Responsabilite civile' => 'respons_civile',
                   'Catastrophes naturelles' => 'catastrophe_naturel',
                   'Accidents de la vie privée' => 'accident_vie_prive'

            ]
       ];
    }

    /**
     * Permet la configuration du champ Qualification !
     * 
     */
    private function getConfigurationQualif()
    {
       return
       [
            'choices' => [

               '--Veuillez choisir une qualification--' => 'null',
               
               'Particuliers' => 'particulier',
               'Professionnels' => 'professionnel',
               'Entreprises' => 'entreprise',
               'Exploitants agricoles' => 'exploitant_agricole',
               'Collectivités territoriales' => 'collectivité_territoriale'
                

            ]
       ];
    }


}
