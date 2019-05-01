<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
      ->add('name')
      ->add('iddocument')
      ->add('email')
      ->add('phone_one')
      ->add('phone_two')
      ->add('additional_info')
      ->add('save', SubmitType::class);
    }


}
