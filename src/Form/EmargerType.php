<?php

namespace App\Form;

use App\Entity\Emarger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EmargerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('presence', ChoiceType::class, [
                'choices' => [
                    '' => null,
                    'Présent' => true,
                    'Absent' => false,
                ],
            ])
            ->add('alternative')
            ->add('heureArrive', null, [
                'widget' => 'single_text',
            ])
            ->add('heureDepart', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emarger::class,
        ]);
    }
}
