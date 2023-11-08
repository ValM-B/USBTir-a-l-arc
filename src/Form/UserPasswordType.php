<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('password',RepeatedType::class,[
                "type" => PasswordType::class,
                "first_options" => ["label" => "Entrez un nouveau mot de passe","help" => "Le mot de passe doit contenir :
                plus de 6 caractères,
                au moins une lettre majuscule,
                au moins une lettre minuscule,
                au moins un chiffre, 
                aucun espace."],
                "second_options" => ["label" => "Confirmez le mot de passe"],
                "invalid_message" => "Les champs doivent être identiques",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
