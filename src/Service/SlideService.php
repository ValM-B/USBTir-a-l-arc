<?php
namespace App\Service;

class SlideService
{
	private $picturesUrl = [
		"public/images/competition.jpg",
		"public/images/coupe-florence-villars.jpg",
		"public/images/coupe-florence-villars-2.jpg",
		"public/images/coupe-florence-villars-3.jpg",
		"public/images/espace-florence-villars.jpg",
		"public/images/cours-baby.jpg",
		"public/images/fleches-en-cible.jpg",
		"public/images/handisport.jpg",
		"public/images/salle.jpg",
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