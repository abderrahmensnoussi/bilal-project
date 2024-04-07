<?php

namespace App\Form;

use App\Entity\Promotion;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['admin'] === true) {
            $builder
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
                    'required' => false,
                ])
                ->add('formateur', EntityType::class, [
                    'class' => Utilisateur::class,
                    'query_builder' => function (EntityRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('u')
                            ->where('u.roles like \'%ROLE_FORMATEUR%\'');
                    },
                    'choice_label' => function($utilisateur) {
                        return $utilisateur->getNomNaissance() . ' ' . $utilisateur->getPrenom();
                    },
                    'placeholder' => '',
                    'required' => false,
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
                    'required' => false,
                ])
            ;
        }
        
        $builder->add('dateDebut', DateType::class, [
                'label' => '',
                'required' => false,
            ])
            ->add('dateFin', DateType::class, [
                'label' => '',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'admin' => null,
        ]);
    }
}
