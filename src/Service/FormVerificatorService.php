<?php
namespace App\Service;

use App\Repository\UserRepository;

class FormVerificatorService {

	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Check if the email is already used
	 *
	 * @param User $user
	 * @return boolean
	 */
	public function checkEmail($user)
	{
		$userFind = $this->userRepository->findOneBy(['email' => $user->getEmail()]);
		if($userFind && !$user->getId() || $userFind && $userFind->getId() != $user->getId()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if the licence number is already used
	 *
	 * @param User $user
	 * @return boolean
	 */
	public function checkLicenceNumber($user)
	{
		$userFind = $this->userRepository->findOneBy(['licenceNumber' => $user->getLicenceNumber()]);
		if($userFind && !$user->getId() || $userFind && $userFind->getId() != $user->getId()) {
			return true;
		} else {
			return false;
		}
	}

}