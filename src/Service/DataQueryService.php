<?php
namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class DataQueryService
{
	private $request;
	private $userRepository;

	public function __construct(RequestStack $request, UserRepository $userRepository)
	{
		$this->request = $request;
		$this->userRepository = $userRepository;
	}

	/**
	 * Get users based on a search
	 *
	 * @return array
	 */
	public function search()
	{	
		if($this->request->getCurrentRequest()->query->has('search')) {
			$search = $this->request->getCurrentRequest()->query->get('search');
			return $search;
		}
	}

	/**
	 * filled the orderBy parameter with the "sort" parameter if it exists in the url
	 *
	 * @return array
	 */
	public function orderBy()
	{
		$orderBy = null;
		// get the result of search request in url (/users?sort=[string])
		if ($this->request->getCurrentRequest()->query->has('sort')) {
			// $orderBy[$this->request->getCurrentRequest()->query->get('sort')] = "ASC";
			$orderBy = $this->request->getCurrentRequest()->query->get('sort');
		}
		return $orderBy;
	}

	/**
	 * Get all users of one page, the number of pages and the current page
	 * 
	 * @return array 
	 */
	public function getUsersOfOnePage()
	{
		// get the page number in url (/users?page=[int])
		$page = (int) $this->request->getCurrentRequest()->query->get('page', 1);
		//sets the number of users to display on the page
		$limit = 20;
		//sets the number of users of previous pages not to be retrieved
		$offset = ($page - 1) * $limit;
		$users = $this->userRepository->searchUsers($this->search(), $this->orderBy(), $limit, $offset);
		$nbPages = ceil($this->getNumberOfPages() / $limit);
		
		return ["users" => $users, "currentPage" => $page, "nbPages" => $nbPages];
	}

	/**
	 * get the number of users to display
	 *
	 * @return int number of pages
	 */
	public function getNumberOfPages()
	{
		return count($this->userRepository->searchUsers($this->search(), $this->orderBy(), null, null));
		
	}
	
}