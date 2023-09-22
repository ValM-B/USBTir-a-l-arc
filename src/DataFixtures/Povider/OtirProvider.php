<?php
namespace App\DataFixtures\Provider;

class OtirProvider
{
	private $prices = [
		[ 
			"name" => "Baby",
			"ageMin" => 6,
			"ageMax" => 8,
		],
		[ 
			"name" => "Poussin",
			"ageMin" => 9,
			"ageMax" => 11,
		],
		[ 
			"name" => "Jeune Débutant",
			"ageMin" => 12,
			"ageMax" => 17,
		],
		[ 
			"name" => "Jeune Confirmé",
			"ageMin" => 12,
			"ageMax" => 17,
		],
		[ 
			"name" => "Adulte Débutant",
			"ageMin" => 18,
			"ageMax" => null,
		],
		[ 
			"name" => "Adulte Confirmé",
			"ageMin" => 18,
			"ageMax" => null,
		]
	];

	private $courseTypes = [
		"Baby",
		"Jeunes débutants",
		"Jeunes perfectionnement",
		"Jeunes compétiteurs",
		"Adultes débutants",
		"Adultes perfectionnement",
		"Adultes compétiteurs",
		"Handisport"
	];

	private $userWithPosition = [
		[
			"position" => "Président",
			"role" => ['ROLE_ADMIN']
		],
		[
			"position" => "Secrétaire",
			"role" => ['ROLE_ADMIN']
		],
		[
			"position" => "Trésorier",
			"role" => ['ROLE_ADMIN']
		],
		[
			"position" => "Entraîneur",
			"role" => ['ROLE_USER']
		]
	];

	private $hours = [
		"14:00:00",
		"16:00:00",
		"18:00:00",
		"20:00:00"
	];

	private $days = [
		"Lundi",
		"Mardi",
		"Mercredi",
		"Jeudi",
		"Vendredi",
		"Samedi",
		
	];

	/**
     *Get array of prices
	 * @return array
     */
    public function getPrices()
    {
        return $this->prices;
    }

	/**
     * Get array of course types
	 * @return array
     */
    public function getCourseTypes()
    {
        return $this->courseTypes;
    }

	/**
     * Get array of users with position
	 * @return array
     */
    public function getUserWithPosition()
    {
        return $this->userWithPosition;
    }

	/**
     * Get radom hour
	 * @return string random hour
     */
    public function getRandomHour()
    {
       
        return $this->hours[array_rand($this->hours)];
    }

	/**
     * Get radom day
	 * @return string random day
     */
    public function getRandomDay()
    {
       
        return $this->days[array_rand($this->days)];
    }
}