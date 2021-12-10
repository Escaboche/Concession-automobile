<?php

namespace App\Form;

use App\Entity\Modele;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('immatriculation',TextType::class)
            ->add('nbPortes' ,IntegerType::class)
            ->add('Annee' ,TextType::class, [
                
            ])
            ->add('modele',EntityType::class,[
                'class' => Modele::class,
                'choice_label' => 'libelle',
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
