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
			"ageMax" =>  null,
		],
		[ 
			"name" => "Adulte Confirmé",
			"ageMin" => 18,
			"ageMax" =>  null,
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

	/**
     * Return array of prices
	 * @return array
     */
    public function prices()
    {
        return $this->prices;
    }

	/**
     * Return array of course types
	 * @return array
     */
    public function courseTypes()
    {
        return $this->courseTypes();
    }
}