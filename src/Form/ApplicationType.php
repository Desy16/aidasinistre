<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;


class ApplicationType extends AbstractType{

    /**
     * Permet la configuration de base d'un champ !
     * 
     * @param string $label
     * @param string $placeholder
     * @return array $options
     */
    protected function getConfiguration($label, $placeholder, $options=[])
    {
       return array_merge([
        'label' => $label,
        'attr' => [
            'placeholder' => $placeholder
        ]
       ], $options);
    }

}
?>