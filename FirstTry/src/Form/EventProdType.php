<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\EventProd;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventProdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('refProd')
            ->add('NomProduit')
            ->add('taux')
            ->add('evenement',EntityType::class,
            ['class'=>Evenement::class,
                'choice_label'=>'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventProd::class,
        ]);
    }
}
