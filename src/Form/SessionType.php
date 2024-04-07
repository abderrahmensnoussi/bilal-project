<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Promotion;
use App\Entity\SalleClasse;
use App\Entity\Session;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule')
            ->add('dateSession', null, [
                'widget' => 'single_text',
            ])
            ->add('heureDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('heureFin', null, [
                'widget' => 'single_text',
            ])
            ->add('commentaire')
            ->add('salle', EntityType::class, [
                'class' => SalleClasse::class,
                'choice_label' => 'nomSalle',
                'placeholder' => '',
            ])
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'nomMatiere',
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
