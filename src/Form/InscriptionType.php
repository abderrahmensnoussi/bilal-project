<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Promotion;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEntree', null, [
                'widget' => 'single_text',
            ])
            ->add('dateSortie', null, [
                'widget' => 'single_text',
            ])
            ->add('eleve', EntityType::class, [
                'class' => Utilisateur::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles like \'%ROLE_ELEVE%\'');
                },
                'choice_label' => function($utilisateur) {
                    return $utilisateur->getNomNaissance() . ' ' . $utilisateur->getPrenom();
                },
                'placeholder' => '',
            ])
            ->add('promotion', EntityType::class, [
                'class' => Promotion::class,
                'choice_label' => function($promotion) {
                    $option = '';
                    if ($promotion->getFormation()->getOptions() !== null) {
                        $option = ' - ' . $promotion->getFormation()->getOptions()->getNomOption();
                    }
                    return $promotion->getFormation()->getSpecialite() . $option . ' ' . $promotion->getAnnee();
                },
                'placeholder' => '',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
