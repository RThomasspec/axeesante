<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Dupont'],
                'label' => 'Nom'
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Jean'],
                'label' => 'Prénom'
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => '123 rue de Paris'],
                'label' => 'Adresse'
            ])
            ->add('datedenaissance', DateType::class, [
                'widget' => 'single_text', // important pour un input moderne
                'attr' => ['class' => 'form-control'],
                'label' => 'Date de naissance'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
