<?php

namespace App\DataFixtures;

use App\DataFixtures\Provider\OtirProvider;
use App\Entity\Course;
use App\Entity\CourseType;
use App\Entity\Tarif;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $provider = new OtirProvider();

        //Tarifs
        foreach ($provider->prices() as $price) {
            $newPrice = new Tarif;
            $newPrice->setName($price["name"]);
            $newPrice->setAgeMin($price["ageMin"]);
            $newPrice->setAgeMax($price["ageMax"]);
            $newPrice->setAmount($faker->numberBetween(80,200));
            $newPrice->setGearAmount(30);
            $newPrice->setCreatedAt(new DateTimeImmutable());
            $manager->persist($newPrice);
        }

        //Course Types
        $courseTypes = [];
        foreach ($provider->courseTypes() as $type) {
           $newType = new CourseType;
           $newType->setName($type);
           $newType->setCreatedAt(new DateTimeImmutable());
           $courseTypes[] = $newType;
           $manager->persist($newType);
        }

        //Create 10 courses
        $courses = [];
        for ($p=0; $p < 10 ; $p++) { 
            $newCourse = new Course;
            $newCourse->setDay($faker->dayOfWeek());
            $newCourse->setHour(new DateTime($faker->numberBetween(10, 20)));
            $newCourse->setCourseType($courseTypes[array_rand($courseTypes)]);
            $newCourse->setName($newCourse->getCourseType()->getName()." ".$newCourse->getDay());
            $newCourse->setCreatedAt(new DateTimeImmutable());
            $courses[] = $newCourse;
            $manager->persist($newCourse);
        }


        $manager->flush();
    }
}
