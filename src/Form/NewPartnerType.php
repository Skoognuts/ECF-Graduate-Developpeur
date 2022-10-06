<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewPartnerType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email', TextType::class, ['required' => true, 'mapped' => false, 'attr' => ['autocomplete' => 'off']])
      ->add('plainPassword', PasswordType::class, ['required' => true, 'mapped' => false, 'attr' => ['autocomplete' => 'off']])
      ->add('city', TextType::class, ['required' => true, 'attr' => ['autocomplete' => 'off']])
      ->add('isActive', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'required' => false
      ])
      ->add('globalPermission1', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'mapped' => false,
        'required' => false
      ])
      ->add('globalPermission2', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'mapped' => false,
        'required' => false
      ])
      ->add('globalPermission3', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'mapped' => false,
        'required' => false
      ])
      ->add('globalPermission4', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
        'mapped' => false,
        'required' => false
      ])
      ->add('globalPermission5', CheckboxType::class, [
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
        'data_class' => Partner::class,
      ]);
    }
}