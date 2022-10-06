<?php

namespace App\Form;

use App\Entity\Partner;
use App\Entity\Structure;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewStructureType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email', TextType::class, ['required' => true, 'mapped' => false, 'attr' => ['autocomplete' => 'off']])
      ->add('plainPassword', PasswordType::class, ['required' => true, 'mapped' => false, 'attr' => ['autocomplete' => 'off']])
      ->add('partnerId', EntityType::class, ['class' => Partner::class, 'multiple' => false, 'required' => true])
      ->add('address', TextType::class, ['required' => true, 'attr' => ['autocomplete' => 'off']])
      ->add('phone', TextType::class, ['required' => true, 'attr' => ['autocomplete' => 'off']])
      ->add('isActive', CheckboxType::class, [
        'attr' => ['class' => 'form-check-input', 'type' => 'checkbox', 'role' => 'switch'],
        'label_attr' => ['class' => 'form-ckeck-label'],
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