<?php

namespace App\DataFixtures;

use App\DataFixtures\Provider\OtirProvider;
use App\Entity\Course;
use App\Entity\CourseType;
use App\Entity\Tarif;
use App\Entity\User;
use App\Entity\UserCourse;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    /**
     * will be executed when we load the fixtures
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $provider = new OtirProvider();

        //Create all Tarifs
        foreach ($provider->getPrices() as $price) {
            $newPrice = new Tarif;
            $newPrice->setName($price["name"]);
            $newPrice->setAgeMin($price["ageMin"]);
            if($price["ageMax"]) {
                $newPrice->setAgeMax($price["ageMax"]);
            }
            $newPrice->setAmount($faker->numberBetween(80,200));
            $newPrice->setGearAmount(30);
            $newPrice->setCreatedAt(new DateTimeImmutable());
            $manager->persist($newPrice);
        }

        //Create all Course Types
        $courseTypes = [];
        foreach ($provider->getCourseTypes() as $type) {
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
            $newCourse->setDay($provider->getRandomDay());
            $newCourse->setHour(new DateTime($provider->getRandomHour()));
            $newCourse->setCourseType($courseTypes[array_rand($courseTypes)]);
            $newCourse->setName($newCourse->getCourseType()->getName()." ".$newCourse->getDay());
            $newCourse->setCreatedAt(new DateTimeImmutable());
            $courses[] = $newCourse;
            $manager->persist($newCourse);
        }

        //Create 30 users without position
        for ($u=0; $u < 30 ; $u++) { 
            $newUser = new User;
            $newUser->setLicenceNumber($faker->randomNumber(7, true).$faker->randomLetter());
            $newUser->setFirstname($faker->firstname());
            $newUser->setLastname($faker->lastname());
            $newUser->setDateOfBirth(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-80 years', '-6 years')));
            $newUser->setEmail($faker->email());
            $newUser->setPassword($this->passwordHasher->hashPassword($newUser, $newUser->getFirstname()));
            $newUser->setSubscription($faker->numberBetween(0, 1));
            $newUser->setPosition(null);
            $newUser->setRoles(['ROLE_USER']);
            $newUser->setCreatedAt(new DateTimeImmutable());

            //Create 1 or 2 UserCourse for the current user
            for ($i=0; $i <= mt_rand(0, 1) ; $i++) { 
                $userCourse = new UserCourse;
                $userCourse->setUser($newUser);
                $userCourse->setCourse($courses[array_rand($courses)]);
                $manager->persist($userCourse);
            }

            $manager->persist($newUser);

        }

        //Create users with position or/and role admin
        //We assume that users with a position don't attend a course and are at least 18 years old
            foreach ($provider->getUserWithPosition() as $user) {
                $newUser = new User;
                $newUser->setLicenceNumber($faker->randomNumber(7, true).$faker->randomLetter());
                $newUser->setFirstname($faker->firstname());
                $newUser->setLastname($faker->lastname());
                $newUser->setDateOfBirth(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-80 years', '-18 years')));
                $newUser->setEmail($faker->email());
                $newUser->setPassword($this->passwordHasher->hashPassword($newUser, $newUser->getFirstname()));
                $newUser->setSubscription($faker->numberBetween(0, 1));
                $newUser->setPosition($user['position']);
                $newUser->setRoles($user['role']);
                $newUser->setCreatedAt(new DateTimeImmutable());  
                $manager->persist($newUser);      
            }


        $manager->flush();
    }
}
