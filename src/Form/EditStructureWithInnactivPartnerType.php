<?php

namespace App\Form;

use App\Entity\Structure;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditStructureWithInnactivPartnerType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('localPermission1', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'mapped' => false,
        'required' => false
      ])
      ->add('localPermission2', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'mapped' => false,
        'required' => false
      ])
      ->add('localPermission3', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'mapped' => false,
        'required' => false
      ])
      ->add('localPermission4', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'mapped' => false,
        'required' => false
      ])
      ->add('localPermission5', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'mapped' => false,
        'required' => false
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
    {
      $resolver->setDefaults([
        'data_class' => Structure::class,
      ]);
    }
}