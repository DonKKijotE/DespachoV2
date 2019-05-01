<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Invoice;


class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kind')
            ->add('concept')
            ->add('amount')
            ->add('invoiceConcepts', CollectionType::class, [
            'entry_type' => InvoiceConceptType::class,
            'entry_options' => ['label' => false],
            'label' => false,
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true, ]);
            //->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }

}
