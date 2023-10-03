<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                "label" => "Email de l'utilisateur",
                "attr" => [
                    "placeholder" => "exemple@gmail.com"
                ]
            ])
            ->add('roles', ChoiceType::class,[
                "choices" => [
                    "Administrateur" => "ROLE_ADMIN",
                    "Licencié" => "ROLE_USER"
                ],
                "multiple" => true,
                "expanded" => true,
                "label" => "Privilèges"
            ])
            ->add('password',RepeatedType::class,[
                "type" => PasswordType::class,
                "first_options" => ["label" => "Rentrez un mot de passe","help" => "Le mot de passe doit avoir minimum 4 caractères"],
                "second_options" => ["label" => "Confirmez le mot de passe"],
                "invalid_message" => "Les champs doivent être identiques",
                "label" => "Mot de passe"
            ])
            ->add('licenceNumber')
            ->add('firstname', TextType::class, [
                "label" => "Prénom"
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom"
            ])
            ->add('dateOfBirth', TypeDateType::class, [
                'widget' => 'choice',
                "label" => "Date de naissance"
            ])
            ->add('subscription', ChoiceType::class,[
                "choices" => [
                    "Payée" => true,
                    "Non payée" => false
                ],
 
                "label" => "Cotisation"
            ])
            ->add('position', TextType::class, [
                "label" => "Fonction au sein du Club",
                "attr" => [
                    "placeholder" => "Président, Trésorier etc..."
                ]
            ])
   
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
