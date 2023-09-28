<?php
namespace App\Service;

class SlideService
{
	private $picturesUrl = [
		"competition.jpg",
		"coupe-florence-villars.jpg",
		"coupe-florence-villars-2.jpg",
		"coupe-florence-villars-3.jpg",
		"espace-florence-villars.jpg",
		"cours-baby.jpg",
		"fleches-en-cible.jpg",
		"handisport.jpg",
		"salle.jpg",
	];

	/**
	 * Get random pictures from $picturesUrl
	 *
	 * @param int $nb : number of picture to return
	 * @return array random pictures
	 */
	public function getRandomPictures($nb)
	{
		//get random keys in $picturesUrl
		$randomKeys = array_rand($this->picturesUrl, $nb);

		//push the value of each key in the array $pictures
		$pictures = [];
		foreach ($randomKeys as $key) {
			$pictures[] = $this->picturesUrl[$key];
		}

		return $pictures;
	}
}