<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ids', IdType::class, [
                'label' => false])
            ->add('mobilePhone', TelType::class, [
                'attr' => [
                    'pattern' => "(\+?\d[- .]*){7,13}",
                ]
            ])
            ->add('fullName', TextType::class)
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('subscriptions', CollectionType::class, [
                'entry_type' => SubscriptionType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false
            ])
            ->add('customFields', CollectionType::class, [
                'entry_type' => CustomFieldType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false
            ])
            ->add('submit', SubmitType::class,
                [
                    'attr' => [
                        'class' => "btn btn-secondary btn-lg btn-block"
                    ]
                ]);
    }
}