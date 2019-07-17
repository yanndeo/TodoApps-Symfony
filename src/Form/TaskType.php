<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //parent::buildForm($builder, $options);
        $builder
            ->add('name', TextType::class, [
                'label'=>'Nom'
            ])

            ->add('description', TextareaType::class,[
                'label'=> 'description',
                'required'=>false
            ])

            ->add('dueDate', DateTimeType::class, [
                'label'=> 'Date d\'échéance',
                'required' => false,
                'widget'=> 'single_text', //contruit moi un seul champs tous par la datime
                 'attr'=> [
                     'class'=> 'form-control input-inline datetimepicker', //La class datetime me permettra de le cibler en js
                     'html5'=>false ,// N'utilise pas les options de html5 pour faire le rendu
                 ]

            ])

            ->add('reminder', NumberType::class, [
                'label'=> 'Date de rappel',
                'required' => false
            ])


            ->add('save', SubmitType::class, [
                'attr'=>[
                    'class'=> 'btn btn-primary btn-lg btn-block',
                    'style'=> 'background-color:#5060dc'
                ]
            ]);
    }

}