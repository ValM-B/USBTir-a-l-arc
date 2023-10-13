<?php

namespace App\Form;

use Assert\Range;
use App\Entity\Course;
use App\Entity\CourseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CourseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom du cours"
                ])
            ->add('day', ChoiceType::class,[
                "choices" => [
                    "Lundi" => "Lundi",
                    "Mardi" => "Mardi",
                    "Mercredi" => "Mercredi",
                    "Jeudi" => "Jeudi",
                    "Vendredi" => "Vendredi",
                    "Samedi" => "Samedi",
                ],
                "label" => "Jour",
                'invalid_message' => "Veuillez sélectionner un jour valide."
            ])
            ->add('hour', TimeType::class, [
                "label" => "Heure"
                ])
            ->add('courseType', EntityType::class, [
                'class' => CourseType::class,
                "label" => "Type du cours"
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
