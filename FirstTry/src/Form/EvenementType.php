<?php

namespace App\Form;


use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
                'attr' => array('class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                    'data-format' => 'dd-mm-yyyy HH:ii',
                )))
            ->add('dateFin', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
                'attr' => array('class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                    'data-format' => 'dd-mm-yyyy HH:ii',
                ))
            )
            ->add('image',FileType::class ,['label'=>'choisir'
            ,'mapped'=>false
            ])
            ->add('nom')



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
