<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Título da tarefa'
            ])
            ->add('status', TextType::class, [
            ])->add('status', CheckboxType::class, [
                'label'    => 'Concluída?',
                'required' => false
            ])->add('deadline', TextType::class, [
                'label' => 'Data de vencimento',
                'required' => false,
                'attr' => [
                    'placeholder' => 'DD-MM-YYYY',
                    'pattern' => '\d{2}-\d{2}-\d{4}',
                    'title' => 'Formato: DD-MM-YYYY'
                ]
            ])->add('description', TextType::class, [
                'label' => 'Descrição',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Descrição da tarefa'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}