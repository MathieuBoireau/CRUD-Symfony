<?php

namespace App\Form;

use App\Entity\Etablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('nature', TextType::class)
            ->add('secteur', ChoiceType::class, [
                'choices' => [
                    'Public' => 'Public',
                    'Privé' => 'Privé'
                ]
            ])
            ->add('latitude', NumberType::class)
            ->add('longitude', NumberType::class)
            ->add('adresse', TextType::class)
            ->add('departement', TextType::class)
            ->add('region', TextType::class)
            ->add('commune', TextType::class)
            ->add('academie', TextType::class)
            ->add('date_ouverture', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('Sauvegarder', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}
