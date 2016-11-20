<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapInputType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('terrain', TextareaType::class, [
                'label' => 'Terrain: (X = Goal, * = Start, 9 = Wall)',
                'required' => true,
                'attr' => [
                    'cols' => 100,
                    'rows' => 30
                ],
                'data'=>
'. . . . . . . . . . . .
. 9 9 9 . . . . . . . .
. . . 9 . . . . . . . .
. X . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . . . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 9 9 9 9 9 . . .
. . . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 . . * . . . . .
. . . 9 . . . . . . . .
. . . 9 9 9 9 9 9 9 9 .
. . . 9 . . . . . . . .
. . . . . . . . . . . .'

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'GO!'
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MapInput'
        ));
    }
}
