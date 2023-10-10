<?php

namespace App\Form;

use App\Entity\Tarif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                "label" => "Nom",
            ])            
            ->add('ageMin', IntegerType::class,[
                "label" => "Age minimal",
                "attr" => [
                    "min" => 1,
                ]
            ])
            ->add('ageMax', IntegerType::class,[
                "label" => "Age maximal",
                "attr" => [
                    "min" => 2
                ]
            ])
            ->add('gearAmount', MoneyType::class, [
                "label" => "Montant de l'équipement",
                "attr" => [
                    'maxlength' => 6,
                    'placeholder' => '000.00',
                ]
            ])
            ->add('amount', MoneyType::class, [
                "label" => "Montant",
                "attr" => [
                    'maxlength' => 6,
                    'placeholder' => '000.00',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarif::class,
        ]);
    }
}
