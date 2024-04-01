<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $edit = $options['edit'];
        $builder
            ->add('email')
            ->add('civilite', ChoiceType::class, [
                'label' => 'Civilité',
                'choices' => [
                    '' => null,
                    'Mr' => true,
                    'Mme' => false,
                ],
            ])
            ->add('nomUsuel')
            ->add('nomNaissance')
            ->add('prenom')
            ->add('numtel')
        ;
        if ($edit === false) {
            $builder->add('password', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('role', ChoiceType::class, [
                'mapped' => false,
                'choices'  => [
                    '' => null,
                    'Formateur' => 1,
                    'eleve' => 2,
                ],
                'required' => true,
            ])
            ;
        }
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'edit' => null,
        ]);
    }
}
