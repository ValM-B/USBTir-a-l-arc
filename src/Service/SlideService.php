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

	public function getRandomPictures($nb)
	{
		return array_rand($this->picturesUrl, $nb);
		
	}
}