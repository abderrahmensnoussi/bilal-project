<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Promotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('annee')
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
            ])
            ->add('formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => function($formation) {
                    $option = '';
                    if ($formation->getOptions() !== null) {
                        $option = ' - ' . $formation->getOptions()->getNomOption();
                    }
                    return $formation->getSpecialite() . $option;
                },
                'placeholder' => '',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
